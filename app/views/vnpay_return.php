<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VNPAY RESPONSE</title>
    <!-- Bootstrap core CSS -->
    <link href="/electromart/public/css/vnpay/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="/electromart/public/css/vnpay/jumbotron-narrow.css" rel="stylesheet">
</head>

<body>
    <?php
    $responseCode = $query['vnp_ResponseCode'] ?? '';
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <title>VNPAY RESPONSE</title>
        <link href="/vnpay_php/assets/bootstrap.min.css" rel="stylesheet" />
        <link href="/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">
        <script src="/vnpay_php/assets/jquery-1.11.3.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">VNPAY RESPONSE</h3>
            </div>
            <div class="table-responsive">
                <div class="form-group">
                    <label>Mã đơn hàng:</label>
                    <label><?php echo $query['vnp_TxnRef'] ?? '' ?></label>
                </div>
                <div class="form-group">
                    <label>Số tiền:</label>
                    <label><?php echo $query['vnp_Amount'] ?? '' ?></label>
                </div>
                <div class="form-group">
                    <label>Nội dung thanh toán:</label>
                    <label><?php echo $query['vnp_OrderInfo'] ?? '' ?></label>
                </div>
                <div class="form-group">
                    <label>Mã phản hồi:</label>
                    <label><?php echo $query['vnp_ResponseCode'] ?? '' ?></label>
                </div>
                <div class="form-group">
                    <label>Mã GD Tại VNPAY:</label>
                    <label><?php echo $query['vnp_TransactionNo'] ?? '' ?></label>
                </div>
                <div class="form-group">
                    <label>Mã Ngân hàng:</label>
                    <label><?php echo $query['vnp_BankCode'] ?? '' ?></label>
                </div>
                <div class="form-group">
                    <label>Thời gian thanh toán:</label>
                    <label><?php echo $query['vnp_PayDate'] ?? '' ?></label>
                </div>
                <div class="form-group">
                    <label>Kết quả:</label>
                    <label>
                        <?php
                        if ($isValid) {
                            echo ($responseCode === '00')
                                ? "<span style='color:blue'>GD Thành công</span>"
                                : "<span style='color:red'>GD Không thành công</span>";
                        } else {
                            echo "<span style='color:red'>Chữ ký không hợp lệ</span>";
                        }
                        ?>
                    </label>
                </div>
            </div>
            <footer class="footer">
                <p>&copy; VNPAY <?php echo date('Y') ?></p>
            </footer>
        </div>
    </body>

    </html>