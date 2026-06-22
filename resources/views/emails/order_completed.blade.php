<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Completed</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f5f5f5; padding: 30px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <table width="650"
                       cellpadding="0"
                       cellspacing="0"
                       style="background: #ffffff;
                              border-radius: 10px;
                              overflow: hidden;">

                    <!-- HEADER -->
                    <tr>
                        <td style="background: #28a745;
                                   color: white;
                                   padding: 25px;
                                   text-align: center;">

                            <h1 style="margin:0;">
                                Order Completed
                            </h1>

                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding: 35px;">

                            <p>
                                Hello
                                <strong>{{ $order->ad->name ?? 'AD' }}</strong>,
                            </p>

                            <p>
                                Your assigned order has been successfully completed.
                            </p>

                            <hr>

                            <h3>Order Details</h3>

                            <table width="100%" cellpadding="8">

                                <tr>
                                    <td width="200">
                                        <strong>Order ID</strong>
                                    </td>

                                    <td>
                                        #{{ $order->id }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>Status</strong>
                                    </td>

                                    <td>
                                        {{ $order->status }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>Completed At</strong>
                                    </td>

                                    <td>
                                        {{ date('F d, Y h:i A', strtotime($order->completed_at)) }}
                                    </td>
                                </tr>

                                @if(!empty($order->remarks))
                                    <tr>
                                        <td valign="top">
                                            <strong>Remarks</strong>
                                        </td>

                                        <td>
                                            {{ $order->remarks }}
                                        </td>
                                    </tr>
                                @endif

                            </table>

                            <hr>

                            <p>
                                Thank you for your continuous effort and support.
                            </p>

                            <p>
                                Regards,<br>
                                <strong>{{ config('app.name') }}</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f1f1f1;
                                   text-align:center;
                                   padding:15px;
                                   font-size:12px;
                                   color:#777;">

                            © {{ date('Y') }}
                            {{ config('app.name') }}

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
