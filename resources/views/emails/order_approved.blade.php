<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Terverifikasi - GadgetHub</title>
</head>
<body style="margin: 0; padding: 0; background-color: #0f172a; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #f8fafc;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #0f172a; padding: 40px 0;">
        <tr>
            <td align="center" style="padding: 40px 16px;">
                
                <table role="presentation" style="width: 100%; max-width: 600px; border-collapse: collapse; background-color: #1e293b; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);">
                    
                    <tr>
                        <td style="background: linear-gradient(135deg, #2563eb, #06b6d4); padding: 35px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 800; letter-spacing: -0.5px;">
                                GadgetHub
                            </h1>
                            <p style="margin: 5px 0 0 0; color: #e2e8f0; font-size: 14px; opacity: 0.9;">
                                Status Pesanan: Pembayaran Diterima
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px 40px 30px 40px;">
                            <h2 style="margin: 0 0 16px 0; color: #ffffff; font-size: 22px; font-weight: 700;">
                                Halo, {{ $order->receiver_name }}! 👋
                            </h2>
                            <p style="margin: 0 0 25px 0; color: #cbd5e1; font-size: 15px; line-height: 1.6;">
                                Bagus! Bukti pembayaran Anda untuk nomor pesanan <strong style="color: #38bdf8; font-family: monospace; font-size: 16px;">{{ $order->invoice_number }}</strong> telah sukses diverifikasi oleh tim admin kami.
                            </p>

                            <div style="background-color: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 24px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 14px 0; color: #38bdf8; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">
                                    Detail Pengiriman & Tagihan
                                </h3>
                                
                                <table role="presentation" style="width: 100%; border-collapse: collapse; font-size: 15px;">
                                    <tr>
                                        <td style="padding: 6px 0; color: #94a3b8; width: 30%; valign: top;">Alamat Lengkap</td>
                                        <td style="padding: 6px 0; color: #f8fafc; font-weight: 500;">{{ $order->address }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #94a3b8; valign: top;">Total Bayar</td>
                                        <td style="padding: 6px 0; color: #22c55e; font-weight: 700; font-size: 18px;">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <p style="margin: 0 0 10px 0; color: #cbd5e1; font-size: 15px; line-height: 1.6;">
                                Pesanan Anda kini sedang masuk ke tahap pengemasan dan akan segera diserahkan ke kurir untuk pengiriman. 
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <hr style="border: 0; border-top: 1px solid rgba(255, 255, 255, 0.08); margin-bottom: 30px;">
                            <p style="margin: 0 0 20px 0; color: #94a3b8; font-size: 13px;">
                                Terima kasih telah memercayakan kebutuhan *gadget* Anda di GadgetHub!
                            </p>
                            <p style="margin: 0; color: #64748b; font-size: 11px;">
                                Email ini dikirim secara otomatis oleh sistem GadgetHub. Mohon tidak membalas email ini secara langsung.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>
</html>