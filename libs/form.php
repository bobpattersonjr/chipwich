<?

class form{
    public static function text($field){
        $upper_field = ucwords($field);
        return "<div class='control-group'>
            <!-- {$field} -->
            <label class='control-label' for='{$field}'>{$upper_field}</label>
            <div class='controls'>
              <input type='text' id='{$field}' name='{$field}' placeholder='' class='input-xxlarge'>
            </div>
          </div>";
    }

    public static function textarea($field){
        $upper_field = ucwords($field);
        return "<div class='control-group'>
            <!-- {$field} -->
            <label class='control-label' for='{$field}'>{$upper_field}</label>
            <div class='controls'>
            <textarea id='{$field}' name='{$field}' placeholder='{$field}' class='input-xxlarge input-block-level' rows='6'></textarea>
            </div>
          </div>";
    }

}

?>