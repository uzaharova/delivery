<?php
//Объявление начальных переменных
$valid_types = array('csv'); //тип файла, который можно загружать
$tmp_path_file = sys_get_temp_dir(); //получение пути временной папки, куда будем записывать загружаемый файл
$n_line = 0;

if (!isset($_FILES["userfile"])) {
    echo("Выберите файл");
    return;
}

if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
    $tmp_name = $_FILES['userfile']['tmp_name'];
    $userfile_name = explode('.', $_FILES['userfile']['name']);
    $filename = array_shift($userfile_name);
    $ext = reset($userfile_name);

    if (!in_array($ext, $valid_types)) {
        echo('Ошибка: Неверный тип файла.');
        return;
    }

    if (move_uploaded_file($tmp_name, $tmp_path_file . '/1.csv')) {
        $data_file = fopen($tmp_path_file . '/1.csv', 'r');

        echo('<table border="1">');
        while (($data = fgetcsv($data_file, 1000, ";")) !== false) {
            $color_id = rand($n_line, 255) . ',' . rand($n_line, 255) . ',' . rand($n_line, 255);
            echo('<tr style="background: rgb(' . $color_id . ');">');

            foreach ($data as $value) {
                echo('<th>' . $value . '</th>');
            }
            echo('</tr>');

            $n_line++;
        }
        echo('</table>');
        fclose($tmp_path_file . '/1.csv');

    } else {
        echo('Ошибка: Файл не создан.');
    }
}
