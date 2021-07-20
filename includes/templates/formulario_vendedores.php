<fieldset>
    <legend>Información General</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre del Vendedor(a)" value="<?php echo s($vendedor->nombre); ?>">

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido del Vendedor(a)" value="<?php echo s($vendedor->apellido); ?>">

    <label for="imagen">Perfil:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="vendedor[imagen]">

    <?php if ($vendedor->imagen): ?>
        <img src="/perfiles/<?php echo $vendedor->imagen; ?>" alt="perfil de vendedor" class="imagen-small">
    <?php endif; ?>
</fieldset>

<fieldset>
    <legend>Información de Contacto</legend>
    <label for="telefono">Telefono:</label>
    <input type="tel" id="telefono" name="vendedor[telefono]" placeholder="Telefono del Vendedor(a)" value="<?php echo s($vendedor->telefono); ?>">

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="vendedor[email]" placeholder="Email del Vendedor(a)" value="<?php echo s($vendedor->email); ?>">
</fieldset>