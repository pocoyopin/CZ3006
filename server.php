<!DOCTYPE html>

<html>
    <head>
        <title>Order Receipt</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="styles.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php
            //get values from the form
            $name = $_POST["name"];
            $apple = $_POST["apple"];
            $orange = $_POST["orange"];
            $banana = $_POST["banana"];
            $payment = $_POST["payment"];

            //set value to 0 if no amount is keyed in
            if ($apple == "") {
                $apple = 0;
            }
            if ($orange == "") {
                $orange = 0;
            }
            if ($banana == "") {
                $banana = 0;
            }

            //calculate the total cost
            $total = (0.69 * $apple) + (0.59 * $orange) + (0.39 * $banana);
            $totalCost = number_format($total, 2);
            
            //write to file order.txt
            $filename = "order.txt";
            $file = fopen($filename, "c+");
            $file_contents = file_get_contents($filename);

            $addApple = 0;
            $addOrange = 0;
            $addBanana = 0;

            if ($file_contents !== ""){
                preg_match("/Total number of apples: (\d+)/", $file_contents, $addApple);
                preg_match("/Total number of oranges: (\d+)/", $file_contents, $addOrange);
                preg_match("/Total number of bananas: (\d+)/", $file_contents, $addBanana);

                $addApple = intval($addApple[1]);
                $addOrange = intval($addOrange[1]);
                $addBanana = intval($addBanana[1]);
            }
            
            //to rewrite content
            fseek($file,0);

            $totalApple = $apple + $addApple;
            $totalOrange = $orange + $addOrange;
            $totalBanana = $banana + $addBanana;

            $sold = "Total number of apples: $totalApple\n";
            $sold .= "Total number of oranges: $totalOrange\n";
            $sold .= "Total number of bananas: $totalBanana\n";

            fwrite($file, $sold);
            fclose($file);
        ?>

        <div class="header">
            <h1>Fruit Market</h1>
        </div>

        <div class="body">
            <div class="card bg-light" style="width: 450px;">
                <div class="card-body">
                    <div style="text-align: center;">
                        <legend>Receipt</legend>
                    </div>

                    <ul>
                        <li class="form-row">
                            <label>Name</label>
                            <label> <?php echo $name; ?> </label>
                        </li>
                    </ul>

                    <label>You have purchased:</label>

                    <ul>
                        <li class="form-row">
                            <label>Apple (0.69 each)</label>
                            <label> <?php echo $apple; ?> pcs</label>
                        </li>

                        <li class="form-row">
                            <label>Orange (0.59 each)</label>
                            <label> <?php echo $orange; ?> pcs</label>
                        </li>
                                    
                        <li class="form-row">
                            <label>Banana (0.39 each)</label>
                            <label> <?php echo $banana; ?> pcs</label>
                        </li>
                    </ul>

                    <div>
                        <label>Payment by:</label>
                        <label> <?php echo $payment; ?> </label>
                    </div>                    

                    <div>
                        <label>Total cost: $</label>
                        <label> <?php echo $totalCost; ?> </label>
                    </div>

                    <br>
                    <br>
                    <label>Thank you for shopping with us!</label>

                </div>
            </div>
        </div>
    </body>
</html>