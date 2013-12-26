<?php
/*
Plugin Name: PagoFacil Form
Description: Express Payments with PagoFacil Gateway
Author: Daniel Doctor
Version: 1
Author URI: http://www.bmascreativos.com
*/
class PagoFacilWidget extends WP_Widget
{
  function PagoFacilWidget()
  {
    $widget_ops = array('classname' => 'PagoFacilWidget', 'description' => 'Despliega el formulario de cobro' );
    $this->WP_Widget('PagoFacilWidget', 'Formulario Pago Facil', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $idSucursal = $instance['idSucursal'];
	$idUsuario =  $instance['idUsuario'];
	$Conceptos = $instance['Conceptos'];
	$title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Título: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('idSucursal'); ?>">idSucursal: <input class="widefat" id="<?php echo $this->get_field_id('idSucursal'); ?>" name="<?php echo $this->get_field_name('idSucursal'); ?>" type="text" value="<?php echo attribute_escape($idSucursal); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('idUsuario'); ?>">idUsuario: <input class="widefat" id="<?php echo $this->get_field_id('idUsuario'); ?>" name="<?php echo $this->get_field_name('idUsuario'); ?>" type="text" value="<?php echo attribute_escape($idUsuario); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('Conceptos');?>">Conceptos: (Separado por , para el precio), uno por línea:<textarea id="<?php echo $this->get_field_id('Conceptos'); ?>" name="<?php echo $this->get_field_name('Conceptos'); ?>" class="widefat"><?php echo attribute_escape($Conceptos); ?></textarea></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
	$instance['title'] = $new_instance['title'];
    $instance['idSucursal'] = $new_instance['idSucursal'];
	$instance['idUsuario'] = $new_instance['idUsuario'];
	$instance['Conceptos'] = $new_instance['Conceptos'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
   ?>
	<form id="transaccion" name="transaccion" enctype="application/x-www-form-urlencoded" action="https://www.pagofacil.net/st/public/Payform" method="post">
	<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $instance['idSucursal'];?>"/>
	<input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $instance['idUsuario'];?>"/>
	<input type="hidden" name="idServicio" id="idServicio" value="1">
	<label for="nombre" >Nombre Titular:</label>
	<input type="text" name="nombre" class="required widefat" id="nombre"/><br/>
	<label for="apellidos" >Apellidos titular:</label>
	<input type="text" name="apellidos" id="apellidos"/><br/>
	<label for="numeroTarjeta" >Número Tarjeta:</label>
	<input type="text" name="numeroTarjeta" id="numeroTarjeta"/><br/>
	<label for="cvt" >Código de seguridad</label>
	<input type="text" name="cvt" id="cvt"/><br/>
	<label for="cp" >Código Postal:</label>
	<input type="text" name="cp" id="cp"/><br/>
	<label for="mesExpiracion" >Mes Expiración:</label>
	<input type="text" name="mesExpiracion" id="mesExpiracion" /><br/>
	<label for="anyoExpiracion" >Año de Expiración:</label>
	<input type="text" name="anyoExpiracion" id="anyoExpiracion"/><br/>
	<label for="monto" >Monto:</label>
	<?php 
		$concepts = split("\n",$instance['Conceptos']);
	?><br/>
	<select name="monto" id ="monto">
	<?php	foreach ($concepts as $concept){
		$arr = split(',',$concept);?>
		<option value='<?php echo $arr[1];?>'><?php echo $arr[0];?></option>
	<?php }?>
	</select>
	<br/>
	<label for="email" class="optional">Email:</label><br/>
	<input type="text" name="email" id="email"/><br/>
	<label for="telefono" >Telefono (10 dígitos):</label>
	<input type="text" name="telefono" id="telefono"/><br/>
	<label for="celular" >Celular (10 dígitos):</label>
	<input type="text" name="celular" id="celular"/><br/>
	<label for="calleyNumero" >Calle y Número:</label>
	<input type="text" name="calleyNumero" id="calleyNumero"/><br/>
	<label for="colonia" >Colonia:</label>
	<input type="text" name="colonia" id="colonia"/><br/>
	<label for="municipio" >Municipio:</label>
	<input type="text" name="municipio" id="municipio" ><br/>
	<label for="estado" >Estado:</label>
	<input type="text" name="estado" id="estado"/><br/>
	<label for="pais" >País:</label><br/>
	<input type="text" name="pais" id="pais"/><br/>
	<br/>
	<input type="submit" name="submit" id="submitbutton" value="Realizar Pago">
</form>
    <?php echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("PagoFacilWidget");') );