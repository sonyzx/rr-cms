<form action="<?php echo $purchaseUrl;?>" method="post" name="frmVPOS">
<table>
<tr><td>acquirerId <input type="text" name ="acquirerId" value="<?php echo $acquirerId; ?>" /></td></tr>
<tr><td>idCommerce <input type="text" name ="idCommerce" value="<?php echo $idCommerce; ?>" /></td></tr>
<tr><td>purchaseOperationNumber <input type="text" name="purchaseOperationNumber" value="<?php echo $purchaseOperationNumber;
?>" /></td></tr>
<tr><td>purchaseAmount <input type="text" name="purchaseAmount" value="<?php echo $purchaseAmount; ?>" /></td></tr>
<tr><td>purchaseCurrencyCode <input type="text" name="purchaseCurrencyCode" value="<?php echo $purchaseCurrencyCode; ?>"
/></td></tr> <tr><td>language <input type="text" name="language" value="ES" /></td></tr>
<tr><td>shippingFirstName <input type="text" name="shippingFirstName" value="Carlos" /></td></tr>
<tr><td>shippingLastName <input type="text" name="shippingLastName" value="Shepherd" /></td></tr>
<tr><td>shippingEmail <input type="text" name="shippingEmail" value="alfonso_2709@hotmail.com" /></td></tr>
<tr><td>shippingAddress <input type="text" name="shippingAddress" value="La Requena 165 Surco"
/></td></tr> <tr><td>shippingZIP <input type="text" name="shippingZIP" value="Lima 33" /></td></tr>
<tr><td>shippingCity <input type="text" name="shippingCity" value="Lima" /></td></tr>
<tr><td>shippingState <input type="text" name="shippingState" value="Lima" /></td></tr>
<tr><td>shippingCountry <input type="text" name="shippingCountry" value="PE" /></td></tr>
<tr><td>userCommerce <input type="text" name="userCommerce" value="" /></td></tr>
<tr><td>userCodePayme <input type="text" name="userCodePayme" value="" /></td></tr>
<tr><td>descriptionProducts <input type="text" name="descriptionProducts" value="Producto ABC" /></td></tr>
<tr><td>programmingLanguage <input type="text" name="programmingLanguage" value="PHP" /></td></tr>
<tr><td>purchaseVerification <input type="text" name="purchaseVerification" value="<?php echo $purchaseVerification; ?>"
/></td></tr> <tr><td><input type="submit" value="Comprar"></td></tr>
</table>