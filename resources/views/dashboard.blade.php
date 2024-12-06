<x-app-layout class="bg-white">


    <div class=" bg-white">
       <div class="bg-white flex text-center flex-items justify-center ">
           <h1 class="font-bold text-2xl mt-24"> Obrigado por usar a aplicação!</h1>

       </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-center items-center">
                    <video width="320" height="240" autoplay loop muted>
                        <source src="{{ asset('gifs/thankyou.mp4') }}" type="video/mp4">
                        Seu navegador não suporta a tag de vídeo.
                    </video>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
