<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password – SazeeAI</title>
</head>
<body style="margin:0;padding:0;background-color:#0f172a;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#0f172a;padding:40px 16px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;">

                <!-- Header / Logo -->
                <tr>
                    <td align="center" style="padding-bottom:24px;">
                        <span style="font-size:22px;font-weight:700;color:#a78bfa;letter-spacing:-0.5px;">⚡ SazeeAI</span>
                    </td>
                </tr>

                <!-- Card -->
                <tr>
                    <td style="background-color:#1e293b;border-radius:16px;border:1px solid #334155;padding:40px 36px;">

                        <p style="margin:0 0 8px;font-size:20px;font-weight:700;color:#f1f5f9;">Reset Password Kamu</p>
                        <p style="margin:0 0 28px;font-size:14px;color:#94a3b8;line-height:1.6;">
                            Halo <strong style="color:#e2e8f0;"><?= esc($name) ?></strong>,<br>
                            Kami menerima permintaan reset password untuk akun kamu.<br>
                            Klik tombol di bawah untuk membuat password baru.
                        </p>

                        <!-- CTA Button -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" style="padding:8px 0 28px;">
                                    <a href="<?= $resetLink ?>"
                                       style="display:inline-block;padding:14px 32px;background-color:#7c3aed;color:#ffffff;text-decoration:none;border-radius:10px;font-size:15px;font-weight:600;letter-spacing:0.2px;">
                                        Reset Password
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <!-- Link fallback -->
                        <p style="margin:0 0 6px;font-size:12px;color:#64748b;">Atau copy link berikut ke browser:</p>
                        <p style="margin:0 0 28px;font-size:11px;color:#7c3aed;word-break:break-all;"><?= $resetLink ?></p>

                        <!-- Warning -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="background-color:#1e1b4b;border-left:3px solid #7c3aed;border-radius:0 8px 8px 0;padding:12px 16px;">
                                    <p style="margin:0;font-size:12px;color:#a5b4fc;line-height:1.6;">
                                        ⏱ Link ini akan <strong>kadaluarsa dalam 1 jam</strong>.<br>
                                        Jika kamu tidak meminta reset password, abaikan email ini.
                                    </p>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center" style="padding-top:24px;">
                        <p style="margin:0;font-size:12px;color:#475569;">
                            © <?= date('Y') ?> SazeeAI · 
                            <a href="<?= base_url() ?>" style="color:#7c3aed;text-decoration:none;">sazee.biz.id</a>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
