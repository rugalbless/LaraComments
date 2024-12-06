import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.getElementById("open-camera").addEventListener("click", function () {
    // Acessar a câmera do usuário
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function (stream) {
            // Exibir o vídeo da câmera no elemento <video>
            let video = document.getElementById("video");
            video.srcObject = stream;
        })
        .catch(function (err) {
            console.log("Erro ao acessar a câmera: " + err);
        });
});

document.getElementById("video").addEventListener("click", function () {
    // Quando o usuário clicar no vídeo, capturamos a foto
    let canvas = document.getElementById("canvas");
    let context = canvas.getContext("2d");

    // Definir as dimensões do canvas conforme o vídeo
    let video = document.getElementById("video");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    // Desenhar a imagem do vídeo no canvas
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Converter o canvas para uma imagem (base64)
    let dataUrl = canvas.toDataURL("image/png");

    // Log para verificar se a base64 da imagem está sendo gerada corretamente
    console.log(dataUrl); // Verifique se a imagem base64 está sendo gerada corretamente

    // Definir o campo hidden "image" com a imagem capturada
    document.getElementById("image").value = dataUrl;

    // Parar o stream de vídeo (opcional)
    let stream = video.srcObject;
    let tracks = stream.getTracks();
    tracks.forEach(track => track.stop());

    // Ocultar o vídeo e mostrar a imagem no canvas
    video.style.display = "none";
    canvas.style.display = "block";
});

document.querySelector('form').addEventListener('submit', function (e) {
    let imageData = document.getElementById('image').value;  // Verifica o valor do campo 'image'
    console.log(imageData);  // Verifique no console se a base64 da imagem está sendo enviada corretamente

    if (!imageData) {
        alert('Nenhuma imagem foi selecionada!');
        e.preventDefault();  // Impede o envio se a imagem não estiver presente
    }
});


