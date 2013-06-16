<ul class="nav nav-pills">
  <li class="divider-vertical <?=$this->page == 'start' ? 'active' : ''?>">
    <a href="<?=URL.'admin'?>">Start</a>
  </li>
  <li class="divider-vertical <?=$this->page == 'users' ? 'active' : ''?>">
    <a href="<?=URL.'admin/users'?>">Users</a>
  </li>
  <li class="divider-vertical <?=$this->page == 'images' ? 'active' : ''?>">
    <a href="<?=URL.'admin/imgs'?>">Images</a>
  </li>
</ul>
