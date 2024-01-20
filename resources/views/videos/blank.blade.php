<script>
    if (typeof Echo !== 'undefined') {
        console.log('Echo is defined:', Echo);
    } else {
        console.error('Echo is not defined.');
    }


    Echo.channel('transactions')
        .listen('NewTransaction', (e) => {
            const transactionsContainer = document.getElementById('transactionsContainer');

            // Crear la fila de la tabla para la nueva transacción
            const newTransactionRow = document.createElement('tr');
            newTransactionRow.id = `transaction_${e.transaction.id}`;
            newTransactionRow.innerHTML = `
        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">${e.transaction.id}</td>
        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">${e.transaction.buyer.name}</td>
        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
            <a href="/storage/${e.transaction.photo_path}" target="_blank">Ver Foto</a>
        </td>
    `;

            // Añadir la nueva fila al principio del cuerpo de la tabla
            transactionsContainer.prepend(newTransactionRow);
        });
</script>
<script>
    window.onload = function() {
        var channel = Echo.channel('transactions');
        channel.listen('NewTransaction', function(data) {
            alert(JSON.stringify(data));
        });
    }
</script>