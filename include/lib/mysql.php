<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
$connect  = mysql_connect(SERVER_HOST, DATABASE_USER, DATABASE_PASS, true);
$dataconnect = mysql_select_db(DATABASE_NAME, $connect);
if (!$dataconnect) die('Error: ' . mysql_error());
// Conexión de base de Datos
class MySql {
    public static function dbselect($item, $table, $con) {
        global $connect;
        $table = trim($table);
        $arr   = null;
        $i     = (float) 0;
        $sql   = "SELECT $item FROM " . DATABASE_NAME . '.' . DATABASE_FX . $table;
        if ($con != "") $sql .= " WHERE $con";
        $result = mysql_query($sql, $connect);
        if ($result) {
            while ($myrow = mysql_fetch_row($result)) {
                $count = mysql_num_fields($result);
                for ($j = (float) 0; $j < $count; $j++)
                    $arr[$i][$j] = $myrow[$j];
                $i++;
            }
            mysql_free_result($result);
            return $arr;
        } else return false;
    }
    public static function dbdelete($table, $item) {
        mysql_query('DELETE FROM ' . DATABASE_FX . $table . " WHERE $item");
    }
    public static function dbupdate($table, $name, $item) {
        mysql_query('UPDATE ' . DATABASE_FX . $table . " SET $name WHERE $item");
    }
    public static function dbinsert($table, $name, $item) {
        mysql_query('INSERT INTO ' . DATABASE_FX . $table . " ($name) VALUES ($item)");
    }
}
?>