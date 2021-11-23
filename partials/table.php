<?php
$header = $tableData["header"];
$content = $tableData["content"];
?>

<table role="table">
    <thead role="rowgroup">
        <tr role="row">
            <?php
            foreach ($header as $value) {
                ?>
                <th role="columnheader"><?= $value ?></th>
            <?php } ?>         

        </tr>
    </thead>
    <tbody role="rowgroup">
        <?php
        foreach ($content as $row) {
            ?>
            <tr role="row">
                <?php
                foreach ($row as $col) {
                    ?>
                    <td role="cell"><?= $col ?></td>
                <?php } ?>
            </tr>
        <?php } ?> 
    </tbody>
</table>