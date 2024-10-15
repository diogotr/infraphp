<?php

require_once '../include/db.php';

if (isset($_POST['action']) && htmlspecialchars($_POST['action'])  == 'view') {

    // Get all records from database
    $data = $db->query("SELECT * FROM contact ORDER BY firstname")->fetchAll();

    if (count($data)) {
        $output = '<table class="table table-stripped table-sm table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>E-mail</th>
                <th>Action</th>
            </tr>
        </thead> 
        <tbody>';
        
        foreach ($data as $row) {
            $output .= '<tr class="text-center text-secondary">
                        <td>' . $row['id'] . '</td>
                        <td>' . $row['firstname'] . '</td>
                        <td>' . $row['lastname'] . '</td>
                        <td>' . $row['phone'] . '</td>
                        <td>' . $row['email'] . '</td>                        
                        <td>
                            <a href="#" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal" id="' . $row['id'] . '"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                            <a href="#" title="Delete" class="text-danger delBtn" id="' . $row['id'] . '"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;&nbsp; 
                        </td></tr>';
        }   
        $output .= '</tbody></table>';   
        echo $output;    
    }
    else {
        echo '<h3 class="text-center text-secondary mt-5">No contacts in database</h3>';
    }
}

// Add record 
if (isset($_POST['action']) && htmlspecialchars($_POST['action']) == 'insert') {

    $firstname  = htmlspecialchars($_POST['firstname']);
    $lastname   = htmlspecialchars($_POST['lastname']);
    $email      = htmlspecialchars($_POST['email']);
    $phone      = htmlspecialchars($_POST['phone']);
    $db->query('INSERT INTO contact (firstname,lastname,email,phone) VALUES (?,?,?,?)', $firstname,$lastname,$email,$phone);

}

// Get record info from database
if (isset($_POST['edit_id'])) {
    $id = htmlspecialchars($_POST['edit_id']);   
    echo json_encode($db->query('SELECT * FROM contact WHERE id = ?', $id)->fetchArray());
}

// Update the record
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $id         = htmlspecialchars($_POST['id']);   
    $firstname  = htmlspecialchars($_POST['firstname']);
    $lastname   = htmlspecialchars($_POST['lastname']);
    $email      = htmlspecialchars($_POST['email']);
    $phone      = htmlspecialchars($_POST['phone']);
    $db->query('UPDATE contact SET firstname=?,lastname=?,email=?,phone=? WHERE id=?', $firstname,$lastname,$email,$phone,$id);

}

// Delete the record from database
if (isset($_POST['del_id'])) {
    $id = htmlspecialchars($_POST['del_id']);
    $db->query('DELETE FROM contact WHERE id=?', $id);
}
