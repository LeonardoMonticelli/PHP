<?php
    include_once "navBar.php";
    include_once "dbConnect.php";
    if(!$_SESSION['isUserLoggedIn']) {
        // header("Location: /");
        die("Unauthorised, you are not an user");
    } else {?>
        <h1>Current amount of products in the database</h1>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product name</th>
                <th>Product price</th>
                <th>Stock</td>
            </tr>
    
            <?php
            if (isset($_POST["ProductToBuy"]))
                $sqlSelect = $connection->prepare("select Pr_ID, Pr_Name, Pr_Price, Pr_ItemsInStock from PRODUCTS");
                $selectExe = $sqlSelect->execute();
                if($selectExe){
                    $result = $sqlSelect->get_result();
                    while($row=$result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?=$row["Pr_ID"]?></td>
                            <td><?=$row["Pr_Name"]?></td>
                            <td><?=$row["Pr_Price"]?> Euros</td>
                            <td><?=$row["Pr_ItemsInStock"]?></td>
                            <?php if(isset($_SESSION['role']) && $_SESSION["role"] == "admin"){?>
                            <td>
                                <!-- the delete is taking two clicks to act -->
                                <form method="post">
                                    <input type="hidden" value="<?= $row["Pr_ID"]?>" name="deletePr">
                                    <input type="submit" value="Delete">
                                </form>
                            </td>
                            <?php } else{?>
                                <form method="post">
                                    <input type="hidden" value="<?= $row["Pr_ID"]?>" name="buyPr">
                                    <input type="text" value=0 name="howManyItems">
                                    <input type="submit" value="Buy">
                                </form> 
                            <?php }?>
                        </tr>
                        <?php
                    }
                } else {
                    echo "Something went wrong when selecting data";
                }
                if(isset($_POST["deletePr"])){ 
                    $sqlDelete = $connection->prepare("DELETE from PRODUCTS where Pr_ID=?");
                    if(!$sqlDelete){
                        die("Error in sql selete statement");
                    }
                    $sqlDelete->bind_param("i",$_POST["deletePr"]);
                    $sqlDelete->execute();
                    Header('Location: '.$_SERVER['PHP_SELF']);
                }
            ?>
        </table>
        <?php
    }
?>