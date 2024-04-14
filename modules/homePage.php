<?php
// homePage
if (isset($_SESSION['user'])) {
getModule('homeSlider');

getModule('coursesHomeList');
?>
<div class="pb-3 text-center container">
<a class="seeMoreCurs" href="<?php echo baseUrl().'cursos/1';?>" title="Veja mais cursos">Veja mais cursos</a>
</div>
<?php
} else
{
    getModule('loginRequired');
}
?>


