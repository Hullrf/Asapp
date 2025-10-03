// js/factura.js
document.addEventListener('DOMContentLoaded', function () {
  const ID_PEDIDO = window.ASAPP && window.ASAPP.id_pedido ? window.ASAPP.id_pedido : null;
  const btnPagar = document.getElementById('btnPagar');
  const totalSpan = document.getElementById('total');
  const checkboxes = () => Array.from(document.querySelectorAll('.pay-checkbox'));

  function calcularTotalYEstadoBoton() {
    let total = 0;
    let anyChecked = false;
    checkboxes().forEach(cb => {
      if (cb.checked && !cb.disabled) {
        total += parseFloat(cb.dataset.precio || 0);
        anyChecked = true;
      }
    });
    if (totalSpan) totalSpan.textContent = total.toFixed(2);
    if (btnPagar) btnPagar.disabled = !anyChecked;
  }

  // bind cambios
  checkboxes().forEach(cb => cb.addEventListener('change', calcularTotalYEstadoBoton));
  calcularTotalYEstadoBoton();

  // acción del botón: construir form dinámico y enviarlo por POST a pasarela.php
  if (btnPagar) {
    btnPagar.addEventListener('click', function () {
      if (!ID_PEDIDO) {
        alert('ID de pedido no encontrada. Recarga la página e intenta de nuevo.');
        return;
      }
      const selected = checkboxes().filter(cb => cb.checked && !cb.disabled).map(cb => cb.value);
      if (selected.length === 0) {
        alert('Selecciona al menos un ítem para pagar.');
        return;
      }

      // DEBUG: ver en consola lo que se enviará
      console.log('Enviando a pasarela:', { id_pedido: ID_PEDIDO, items: selected });

      // Crear form
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'pasarela.php';

      // id_pedido
      const inputPedido = document.createElement('input');
      inputPedido.type = 'hidden';
      inputPedido.name = 'id_pedido';
      inputPedido.value = ID_PEDIDO;
      form.appendChild(inputPedido);

      // items[]
      selected.forEach(itemId => {
        const i = document.createElement('input');
        i.type = 'hidden';
        i.name = 'items[]';
        i.value = itemId;
        form.appendChild(i);
      });

      document.body.appendChild(form);
      form.submit();
    });
  }
});
