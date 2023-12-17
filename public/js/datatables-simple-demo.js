window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
    const sentMessages = document.getElementById('sentMessagesTable');
    if (sentMessages) {
        new simpleDatatables.DataTable(sentMessages);
    }
    const receivedMessages = document.getElementById('receivedMessagesTable');
    if (receivedMessages) {
        new simpleDatatables.DataTable(receivedMessages);
    }
});
