<form class="form-search" action="<?=URL.'admin/users'?>" method="post">
  <div class="input-append">
    <input id="search_users" type="text" name='filter' class="span6 search-query" placeholder="Search">
    <button type="submit" class="btn">Search</button>
  </div>
</form>

<?
$headers = array( 'first_name' ,
                  'last_name' ,
                  'birthday' ,
                  'sex' ,
                  'email' ,
                  'signup' ,
                  'last' ,
                  'added' ,
                  'modified' ,
                  'admin',
                  'status');

$address_fields = array('address' ,
                  'city' ,
                  'state' ,
                  'zip' ,);

?>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>id</th>
      <? foreach($headers as $key): ?>
      <th><?=$key?></th>
      <? endforeach;?>
    </tr>
  </thead>
  <tbody>
    <? foreach($this->users_filterd as $user): ?>
    <tr>
      <td><a href="<?=URL.'user/'.$user->_id?>"><?=$user->_id?></a></td>
      <td><?=display_info($user->first_name, 'first_name', $user->_id, 'user')?></td>
      <td><?=display_info($user->last_name, 'last_name', $user->_id, 'user')?></td>
      <td><?=display_info($user->birthday, 'birthday', $user->_id, 'user')?></td>
      <td><?=display_info($user->sex, 'sex', $user->_id, 'user', 'select', 'gender')?></td>
      <td><?=display_info($user->email, 'email', $user->_id, 'user')?></td>
      <td><?=timeago($user->signup)?></td>
      <td><?=timeago($user->last)?></td>
      <td><?=timeago($user->added)?></td>
      <td><?=timeago($user->modified)?></td>
      <td><?=display_info($user->admin, 'admin', $user->_id, 'user', 'select', 'admin')?></td>
      <td><?=display_info($user->status, 'status', $user->_id, 'user')?></td>
    </tr>
    <? endforeach; ?>
  </tbody>
</table>
