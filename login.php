<?php

require('idioma/'.$idioma.'');

echo '
<div id="login">
<b class="rtopc"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
<form method="post" action="index.php">
<ul>
<li>
'.$lengua_usuario.' <input type="text" name="txt_login" maxlength="6" size="6" />
</li>
<li>
'.$lengua_clave.' <input type="password" name="pwd_clave" maxlength="6" size="6"  />
</li>
</ul>
<p><input type="submit" name="boton" value="'.$lengua_entrar.'" /></p>
</form>
<b class="rbottomc"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>
';
?>
