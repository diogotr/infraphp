<?php

require_once '../include/db.php';

if (isset($_POST['action']) && htmlspecialchars($_POST['action'])  == 'view') {

    // Get all records from database
    $data = $db->query("SELECT id,username,created_at,usertype,status FROM users u
                               ORDER BY id DESC")->fetchAll();

    if (count($data)) {
        $output = '<table class="table table-stripped table-sm table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>Name</th>
                <th>Created at</th>
                <th>Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead> 
        <tbody>';
        
        foreach ($data as $row) {
            $output .= '<tr class="text-center text-secondary">
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['username'] . '</td>
                        <td>' . $row['created_at'] . '</td>
                        <td>' . $row['usertype'] . '</td>
                        <td>' . ($row['status'] == 'O' ? 'Open' : 'Closed') . '</td>
                        <td>
                            <a href="#" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal" id="' . $row['id'] . '"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                            <a href="#" title="Delete" class="text-danger delBtn" id="' . $row['id'] . '"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;&nbsp; 
                        </td></tr>';
        }   
        $output .= '</tbody></table>';   
        echo $output;    
    }
    else {
        echo '<h3 class="text-center text-secondary mt-5">No Users in database</h3>';
    }
}

// Add record 
if (isset($_POST['action']) && htmlspecialchars($_POST['action']) == 'insert') {

    $name            = htmlspecialchars($_POST['usertype']);
    $description     = htmlspecialchars($_POST['description']);
    $department_id   = htmlspecialchars($_POST['department_id']);
    $status          = 'O';
    $db->query('INSERT INTO task (name,description,department_id,status) VALUES (?,?,?,?)', $name,$description,$department_id,$status);

}

// Get record info from database
if (isset($_POST['edit_id'])) {
    $id = htmlspecialchars($_POST['edit_id']);   
    echo json_encode($db->query('SELECT * FROM user WHERE id = ?', $id)->fetchArray());
}

// Update the record
if (isset($_POST['action']) && $_POST['action'] == 'update') {

    $id              = htmlspecialchars($_POST['id']);
    $name            = htmlspecialchars($_POST['name']);
    $description     = htmlspecialchars($_POST['description']);
    $department_id   = htmlspecialchars($_POST['department_id']);
    $status          = (htmlspecialchars($_POST['status']) == 'C' ? 'C' : 'O');
    $db->query('UPDATE user SET name=?,description=?,department_id=?,status=? WHERE id=?', $name,$description,$department_id,$status,$id);

}

// Delete the record from database
if (isset($_POST['del_id'])) {
    $id = $_POST['del_id'];
    $otask = task::get($id );
    $otask->delete($id);
}
