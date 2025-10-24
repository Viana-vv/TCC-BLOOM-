document.getElementById("formEnvio").addEventListener("submit", function(event) {
    event.preventDefault();

    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const mensagem = document.getElementById("mensagem").value;

    const dados = { nome, email, mensagem };

    fetch("enviar_email.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(dados)
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("status").textContent = data.message;
    })
    .catch(error => console.error("Erro:", error));
});
