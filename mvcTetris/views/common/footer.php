<script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
  integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
  integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="<?php echo ROOT ?>js/main.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBhlxMfWGY4uVe8zzp-OpbgLwun-KrOKA&callback=initMap"
type="text/javascript"></script>

<?php
$pathToJs = "js/$this->name.js";
if (file_exists($pathToJs)) {
  echo '<script src="' . ROOT . $pathToJs . '"></script>';
}
?>
</body>

</html>