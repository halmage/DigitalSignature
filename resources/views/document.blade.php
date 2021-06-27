<html>
<head>
<title>Prueba
de firma digital</title>
<meta
http-equiv=»Content-Type» content=»text/html;
charset=iso-8859-1″>
<script>
function
firmar(original) {
if
(navigator.appName==»Microsoft Internet Explorer»){
//
Implementar la firma digital con MS IE con CAPICOM
}
else {
return
firmarFirefox(original);
}
}
function
firmarFirefox(original) {
var
firmado = window.crypto.signText(original, «ask»);
if
(firmado.substring(0,5) ==»error») {
alert(«Su
navegador no ha generado una firma valida»);
return
«»;
}
else
if (firmado ==»no generada») {
alert(«No
ha generado la firma.»);
return
«»;
}
else
{
return
firmado ;
alert(«Firma
generada correctamente. Pulse enviar para comprobarlos en
servidor.»);
}
}
</script>
</head>
<body>
<h1>Prueba
de firma digital</h1>
<form
action=»CompruebaFirmaDigital» method=»post»>
<textarea
name=»original» cols=»20″ rows=»20″>Texto
de prueba</textarea>
<textarea
name=»firmado» cols=»20″ rows=»20″></textarea>
<input
type=»button» value=»Firmar»
onclick=»document.forms[0].firmado.value =
firmar(document.forms[0].original.value)»/>
<input
type=»submit» value=»Enviar» />
</form>
</body>
</html>