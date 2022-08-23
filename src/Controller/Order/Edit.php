<?php
namespace Tuan\Fixably\Controller\Order;

use Tuan\Fixably\Controller\BaseController;

class Edit extends BaseController
{
    public function execute()
    {
        echo ('
<form action="/save" method="POST">
    <div>
        <label for="manu">Manufacturer:</label>
        <input type="text" id="manu" name="manu"/>
    </div>
    <div>
        <label for="brand">Brand:</label>
        <input type="text" id="brand" name="brand"/>
    </div>
    <div>
        <label for="type">Type:</label>
        <input type="text" id="type" name="type"/>
    </div>
    <div>
        <label for="desc">Description:</label>
        <input type="text" id="desc" name="desc"/>
    </div>
    <div>
        <input type="checkbox" id="is_sample_order" name="is_sample_order" value="1">
        <label for="is_sample_order">Create Sample Order</label><br>
    </div>
    <button type="submit">Save</button>
</form>
');
    }
}