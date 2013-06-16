<div class="row-fluid">
    <div class="span3">
      <?$source = isset($this->photos[0]) ? $this->photos[0]->url(205,155) : 'http://placehold.it/205x155/aaa&text=User Pic'?>
      <div><?=image($source,205,155);?></div>
      <div id="bootstrapped-fine-uploader"></div>

      <h1><?=$this->user->first_name.' '.$this->user->last_name?></h1>
      <p>Age: <?=$this->user->age_bucket();?></p>
      <p>Email: <?=$this->user->email?></p>
    </div>

    <div class="span6">
    </div>
</div>
