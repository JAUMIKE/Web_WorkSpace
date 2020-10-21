const db = require('./db');
const { Success, Error } = require('./response');
function UPDATE(name, phone, address, adult_mask, child_mask, id) {
    const sql = `UPDATE inventory SET name = ?, phone = ?, address = ?, adult_mask = ?, child_mask = ? WHERE id = ?`;
    const data = [name, phone, address, adult_mask, child_mask, id];
    db.exec(sql, data, function(results, fields) {
        if(results.affectedRows){
            console.log(JSON.stringify(new Success('update success')));
        } else {
            console.log(JSON.stringify(new Error('update failed')));
        }
    });
}

// UPDATE('更改後的診所', '(02)2222-2222', '台北市', 100, 1000, 36);

function DELETE(id) {
    const sql = `DELETE FROM inventory WHERE id = ?;`;
    const data = [id];
    db.exec(sql, data, function(results, fields) {
        if(results.affectedRows){
            console.log(JSON.stringify(new Success('delete success')));
        } else {
            console.log(JSON.stringify(new Error('delete failed')));
        }
    });
}

// DELETE(36);