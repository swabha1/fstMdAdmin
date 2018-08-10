<?php $amount = ($item->price - ($item->price * $item->discount / 100 )) * $item->qty ;
                                                         ?>
<tr id="row_<?php echo $item->sale_item_id; ?>">
    <td><?php echo $item->product_name; ?></td>
    <td><?php echo $item->price; ?> Per <?php echo $item->unit_value." ".$item->unit; ?></td>
    <td><?php echo $item->discount."%"; ?></td>
    <td><span id="span_<?php echo $item->sale_item_id; ?>"><?php echo $item->qty; ?></span><input type="number" value="<?php echo $item->qty; ?>" name="qty[<?php echo $item->sale_item_id; ?>]" id="qty_<?php echo $item->sale_item_id; ?>" style="display: none; width: 60px;" /></td>
    <td><?php echo $amount; ?></td>
    <td>
    <div class="btn-group">
    <a href="javascript:;" style="display: none;" id="btn_save_<?php echo $item->sale_item_id; ?>" data-id="<?php echo $item->sale_item_id; ?>" class="btn btn-success btn-xs btn_save">save</a>
    <a href="javascript:;" id="btn_edit_<?php echo $item->sale_item_id; ?>" data-id="<?php echo $item->sale_item_id; ?>" class="btn btn-success btn-xs btn_edit"><i class="glyphicon glyphicon-edit"></i></a>
    <a href="javascript:;" id="btn_delete_<?php echo $item->sale_item_id; ?>" data-id="<?php echo $item->sale_item_id; ?>" class="btn btn-danger btn-xs btn_delete"><i class="glyphicon glyphicon-remove"></i></a>
    </div>
    </td>
</tr>
