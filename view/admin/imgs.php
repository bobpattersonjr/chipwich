<? $img = array_shift($this->imgs); ?>
<div class="row-fluid">
    <div class="span8 offset1">
        <h4>a: approve ; s: primary ; d: remove</h4>
    </div>
</div>
<div class="row-fluid">
    <div class="span6 approvalcontainer">
        <div class="row-fluid">
            <div class="span3 offset2">
                <button id="approve_img" class="btn approve btn-success" href="<?=URL.'admin/approve_img/'.$img->_id?>" data="<?=$img->_id?>">Approve</button>
            </div>
            <div class="span3">
                <button id="primary_img" class="btn primary btn-primary" href="<?=URL.'admin/primary_img/'.$img->_id?>" data="<?=$img->_id?>">Primary</button>
            </div>
            <div class="span3">
                <button id="remove_img" class="btn remove btn-danger" href="<?=URL.'admin/remove_img/'.$img->_id?>" data="<?=$img->_id?>">Remove</button>
            </div>
        </div>
        <dl class="dl-horizontal">
            <dt>bar name</dt>
            <dd id="img_bar_name"><?=$img->bar->name?></dd>
            <dt>user name</dt>
            <dd id="img_user_name"><?=$img->user ? $img->user->user_name : 'null'?></dd>
            <dt>uploaded</dt>
            <dd><abbr id="timeago_img" class="timeago" title="<?=date('c', $img->added)?>"><?=date("F j, Y, g:i a", $img->added)?></abbr></dd>
            <dt>url</dt>
            <dd id="img_url"><a href="<?=$img->url?>" ><?=$img->filename?></a></dd>
        </dl>
        <img id="img_displayed" src="<?=$img->url?>" height=500 width=500 class="img-rounded" />
        <span class="hide" id="current" data-id="1"></span>
    </div>
    <div class="span6">
        <? $count = 1; $hidden = false; foreach($this->imgs as $img): $count++; if($count > 2){ $hidden = true;}?>
                <img id="<?=$count?>" src="<?=$img->url?>" height=200 width=200 class="img-rounded <?=$hidden ? 'hide' : ''?>" 
                data-date_c="<?=date('c', $img->added)?>"
                date-date_full="<?=date("F j, Y, g:i a", $img->added)?>"
                data-user_name="<?=$img->user ? $img->user->user_name : 'null'?>"
                data-bar_name="<?=$img->bar->name?>"
                data-id="<?=$img->_id?>"
                data-remove="<?=URL.'admin/remove_img/'.$img->_id?>"
                data-approve="<?=URL.'admin/approve_img/'.$img->_id?>"
                data-primary="<?=URL.'admin/primary_img/'.$img->_id?>"
                data-file_name="<?=$img->filename?>"
                />
        <? endforeach;?>
    </div>
</div>

