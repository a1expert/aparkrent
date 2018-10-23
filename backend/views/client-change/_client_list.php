<?php
/**
 * Created at 07.10.2017 19:50
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var Client $client
 */
use backend\models\Client;

?>
<tr class="client">
    <td><?= $client->fullName ?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<?php foreach ($client->changes as $change) {
    echo $this->render('_item', [
        'change' => $change,
        'client' => $client,
    ]);
}
?>
