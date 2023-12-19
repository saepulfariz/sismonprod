<?php

namespace App\Controllers;

use PDO;

use mysqli;
use PDOException;
use App\Controllers\AdminBaseController;

class Backup extends AdminBaseController
{

  public $title = 'Backup Management';
  public $menu = 'backup';
  public $view = 'admin/backup/index';


  public function index()
  {
    $this->permissionCheck('backup_db');
    return view($this->view);
  }


  public function exportDB()
  {
    $this->permissionCheck('backup_db');

    $backup_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.sql';

    $this->Export_Database(false, $backup_name);

    return redirect()->back();
  }

  private function Export_Database($tables = false, $backup_name = false)
  {
    // dd(db_connect());
    $db = db_connect();
    $hostname = $db->hostname;
    $username = $db->username;
    $password = $db->password;
    $database = $db->database;
    $port = $db->port;
    if (db_connect()->DBDriver == 'MySQLi') {
      $name = env('database.default.database');
      $mysqli = new mysqli(env('database.default.hostname'), env('database.default.username'), env('database.default.password'), $name);
      $mysqli->select_db($name);
      $mysqli->query("SET NAMES 'utf8'");

      $queryTables    = $mysqli->query('SHOW TABLES');
      while ($row = $queryTables->fetch_row()) {
        $target_tables[] = $row[0];
      }
      if ($tables !== false) {
        $target_tables = array_intersect($target_tables, $tables);
      }
      foreach ($target_tables as $table) {
        $result         =   $mysqli->query('SELECT * FROM ' . $table);
        $fields_amount  =   $result->field_count;
        $rows_num = $mysqli->affected_rows;
        $res            =   $mysqli->query('SHOW CREATE TABLE ' . $table);
        $TableMLine     =   $res->fetch_row();
        $content        = (!isset($content) ?  '' : $content) . "\n\n" . $TableMLine[1] . ";\n\n";

        for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
          while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
            if ($st_counter % 100 == 0 || $st_counter == 0) {
              $content .= "\nINSERT INTO " . $table . " VALUES";
            }
            $content .= "\n(";
            for ($j = 0; $j < $fields_amount; $j++) {
              $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
              if (isset($row[$j])) {
                $content .= '"' . $row[$j] . '"';
              } else {
                $content .= '""';
              }
              if ($j < ($fields_amount - 1)) {
                $content .= ',';
              }
            }
            $content .= ")";
            //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
            if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
              $content .= ";";
            } else {
              $content .= ",";
            }
            $st_counter = $st_counter + 1;
          }
        }
        $content .= "\n\n\n";
      }
      //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
      $backup_name = $backup_name ? $backup_name : $name . ".sql";
      header('Content-Type: application/octet-stream');
      header("Content-Transfer-Encoding: Binary");
      header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
      echo $content;
      exit;
    } else if (db_connect()->DBDriver == 'sqlsrv') {
      // Server information
      // $server   = $hostname.",port";
      // https://stackoverflow.com/questions/64018598/backup-sql-server-database-using-php
      $server   = $hostname;
      $database = $database;
      $uid      = $username;
      $pwd      = $password;

      // Connection
      try {
        $conn = new PDO("sqlsrv:server=$server;Database=$database", $uid, $pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        die("Error connecting to SQL Server" . $e->getMessage());
      }
      $dir_backup = ROOTPATH . "public";
      $filename = str_replace(".sql", ".bak", $backup_name);

      // Statement
      $sql = "
              DECLARE @date VARCHAR(19)
              SET @date = CONVERT(VARCHAR(19), GETDATE(), 126)
              SET @date = REPLACE(@date, ':', '-')
              SET @date = REPLACE(@date, 'T', '-')

              DECLARE @fileName VARCHAR(100)
              -- SET @fileName = ('d:\backup\BackUp_' + @date + '.bak')
              -- SET @fileName = ('" . $dir_backup . "\backup\BackUp_' + @date + '.bak')
              SET @fileName = ('" . $dir_backup . "\backup\\" . $filename . "')

              BACKUP DATABASE " . $database . "
              TO DISK = @fileName
              WITH 
                  FORMAT,
                  STATS = 1, 
                  MEDIANAME = 'SQLServerBackups',
                  NAME = 'Full Backup of " . $database . "';
              ";
      // dd($sql);
      try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
      } catch (PDOException $e) {
        die("Error executing query. " . $e->getMessage());
      }

      // Clear buffer
      try {
        while ($stmt->nextRowset() != null) {
        };
        echo "Success";
      } catch (PDOException $e) {
        die("Error executing query. " . $e->getMessage());
      }

      // End
      $stmt = null;
      $conn = null;

      $file_name = 'public/backup/' . $filename;

      // make sure it's a file before doing anything
      if (is_file($file_name)) {
        // required for IE
        if (ini_get('zlib.output_compression')) {
          ini_set('zlib.output_compression', 'Off');
        }

        // get the file mime type using the file extension
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
          case 'pdf':
            $mime = 'application/pdf';
            break;
          case 'zip':
            $mime = 'application/zip';
            break;
          case 'jpeg':
          case 'jpg':
            $mime = 'image/jpg';
            break;
          case 'png':
            $mime = 'image/png';
            break;
          default:
            $mime = 'application/force-download';
        }
        header('Pragma: public');   // required
        header('Expires: 0');       // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file_name));    // provide file size
        readfile($file_name);       // push it out
        unlink($file_name);
        die;
      }
    }
  }
}
