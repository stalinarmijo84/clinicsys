<?php 
echo $this->extend('template/layout');
echo $this->section('contenido');

?>
<main class="content">
	<div class="container-fluid p-0">
		<h1 class="h3 mb-3"><strong>Menu Principal</strong> MedicPlus-System</h1>
	</div>
</main>
<?php 
echo $this->endSection();
echo $this->section('script');
?>
<?php 
echo $this->endSection();
?>