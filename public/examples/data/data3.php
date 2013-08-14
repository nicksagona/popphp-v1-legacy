<?php

require_once '../../bootstrap.php';

use Pop\Data;

try {
    $data = array(
        array(
            'id' => 1001,
            'first_name' => 'Bob',
            'last_name'  => 'Smith',
            'birth_date' => '1977-08-19'
        ),
        array(
            'id' => 1002,
            'first_name' => 'Bubba',
            'last_name'  => 'Smith',
            'birth_date' => '1975-01-12'
        ),
        array(
            'id' => 1003,
            'first_name' => 'Ted',
            'last_name'  => 'Smith',
            'birth_date' => '1971-11-21'
        )
    );

    $options = array(
        'form' => array(
            'id'      => 'data-form',
            'action'  => '/some-action',
            'method'  => 'post',
            'process' => '<input type="checkbox" name="rm_users[]" id="rm_users[{i}]" value="[{id}]" />',
            'submit'  => array(
                'class' => 'submit-btn',
                'value' => 'Remove?'
            )
        ),
        'table' => array(
            'cellpadding' => 0,
            'cellspacing' => 0,
            'border'      => 0,
            'class'       => 'data-table'
        ),
        'last_name' => '<a href="/edit/[{id}]">[{last_name}]</a>'
    );

    $html = Data\Type\Html::encode($data, $options);
    echo $html;

} catch (\Exception $e) {
    echo $e->getMessage();
}

