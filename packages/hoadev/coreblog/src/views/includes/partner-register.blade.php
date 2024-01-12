<div class="px-4 pt-4 pb-8 lg:pt-8 lg:pb-8 bg-yellow-500/20 border-t border-yellow-800">
    <div
        x-data="{}"
        class="max-w-7xl mx-auto lg:px-4">


        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">

            <div class="">
                <h2 class="mx-0 font-bold text-2xl text-yellow-800">ĐĂNG KÝ PHÂN PHỐI</h2>
                <p class="mx-0 text-sm">Để tìm hiểu rõ hơn về chính sách hợp tác cùng Sâm Sia Ginseng</p>
            </div>

            <div class="w-full">
                <form @submit.prevent="alert('Tính năng đang phát triển!')"
                    class="w-full flex flex-col md:flex-row gap-4">
                    <input type="text" placeholder="Nhập số điện thoại của bạn"
                        class="w-full border border-yellow-800 rounded-lg" />
                    <input type="email" placeholder="Nhập email của bạn"
                        class="w-full border border-yellow-800 rounded-lg " />
                        <button type="submit" class="py-2 px-4 bg-yellow-800 text-white font-bold uppercase rounded-lg hover:bg-green-800">Gửi</button>
                </form>
            </div>

        </div>

    </div>
</div>
