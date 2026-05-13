<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;
use App\Models\SubscriptionModel;
use App\Models\UserModel;

/**
 * Auth Controller — handles register, login, logout, password reset.
 */
class Auth extends BaseController
{
    protected UserModel         $userModel;
    protected SubscriptionModel $subModel;
    protected ActivityLogModel  $logModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->subModel  = new SubscriptionModel();
        $this->logModel  = new ActivityLogModel();
    }

    // ----------------------------------------------------------------
    // LOGIN
    // ----------------------------------------------------------------

    public function login(): string
    {
        if (session()->get('user_id')) {
            return redirect()->to(base_url('dashboard'));
        }
        return $this->render('auth/login');
    }

    public function doLogin()
    {
        // CSRF is handled by CI4 automatically when enabled
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->findByEmail($email);

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        if (! $user['is_active']) {
            return redirect()->back()->withInput()->with('error', 'Your account has been deactivated.');
        }

        // Fetch subscription info
        $sub = $this->subModel->getByUser($user['id']);

        // Set session
        session()->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['name'],
            'user_email' => $user['email'],
            'user_role'  => $user['role'],
            'user_plan'  => $sub['plan'] ?? 'free',
            'logged_in'  => true,
        ]);

        // Update last login
        $this->userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

        $this->logModel->log('login', 'User logged in', $user['id']);

        $redirect = ($user['role'] === 'admin') ? 'admin' : 'dashboard';
        return redirect()->to(base_url($redirect))->with('success', 'Welcome back, ' . $user['name'] . '!');
    }

    // ----------------------------------------------------------------
    // REGISTER
    // ----------------------------------------------------------------

    public function register(): string
    {
        if (session()->get('user_id')) {
            return redirect()->to(base_url('dashboard'));
        }
        return $this->render('auth/register');
    }

    public function doRegister()
    {
        $rules = [
            'name'             => 'required|min_length[2]|max_length[150]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        $messages = [
            'email'            => ['is_unique' => 'This email is already registered.'],
            'password_confirm' => ['matches'   => 'Passwords do not match.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = $this->userModel->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'), // hashed by model callback
            'role'     => 'user',
            'is_active'=> 1,
        ]);

        // Create free subscription
        $this->subModel->createFreeSubscription($userId);

        $this->logModel->log('register', 'New user registered', $userId);

        return redirect()->to(base_url('auth/login'))->with('success', 'Account created! You can now log in.');
    }

    // ----------------------------------------------------------------
    // FORGOT PASSWORD
    // ----------------------------------------------------------------

    public function forgot(): string
    {
        return $this->render('auth/forgot');
    }

    public function doForgot()
    {
        $email = $this->request->getPost('email');
        $user  = $this->userModel->findByEmail($email);

        if ($user) {
            $token   = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $this->userModel->update($user['id'], [
                'reset_token'   => $token,
                'reset_expires' => $expires,
            ]);
            // In production: send email with reset link
            // For now show the link in flash for development
            $resetLink = base_url("auth/reset/{$token}");
            session()->setFlashdata('reset_link', $resetLink);
        }

        // Always show success to prevent email enumeration
        return redirect()->back()->with('success', 'If that email is registered, a reset link has been sent.');
    }

    public function reset(string $token): string
    {
        $user = $this->userModel->where('reset_token', $token)
            ->where('reset_expires >', date('Y-m-d H:i:s'))
            ->first();

        if (! $user) {
            return redirect()->to(base_url('auth/forgot'))->with('error', 'Invalid or expired reset link.');
        }

        return $this->render('auth/reset', ['token' => $token]);
    }

    public function doReset(string $token)
    {
        $user = $this->userModel->where('reset_token', $token)
            ->where('reset_expires >', date('Y-m-d H:i:s'))
            ->first();

        if (! $user) {
            return redirect()->to(base_url('auth/forgot'))->with('error', 'Invalid or expired reset link.');
        }

        $rules = [
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->skipValidation(true)->update($user['id'], [
            'password'      => $this->request->getPost('password'), // hashed by callback
            'reset_token'   => null,
            'reset_expires' => null,
        ]);

        return redirect()->to(base_url('auth/login'))->with('success', 'Password reset successful. Please log in.');
    }

    // ----------------------------------------------------------------
    // LOGOUT
    // ----------------------------------------------------------------

    public function logout()
    {
        $this->logModel->log('logout', 'User logged out');
        session()->destroy();
        return redirect()->to(base_url('auth/login'))->with('success', 'You have been logged out.');
    }
}
