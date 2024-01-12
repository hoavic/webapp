@extends('coreblog::layouts.blog')

@section('post_title', $post->title)

@php
    if ($post->type === 'page') {
        $contentStyle = 'no-sidebar';
    }
@endphp

@section('content')

    <div class="entry-content box-content">
        <div class="grid gap-4 lg:grid-cols-2 items-center">
            <div class="">
                <img src="/uploads/logo-bot.svg" width="390" height="390" alt="Sâm Sia Ginseng" class="w-80 lg:w-56 mx-auto drop-shadow-lg" loading="lazy">
                <h3 class="text-center font-bold text-2xl uppercase text-yellow-600/80">CÔNG TY TNHH XUẤT NHẬP KHẨU SIA GINSENG</h3>
                <ul>
                    <li class="flex gap-2 items-center">
                        <svg class="w-8 h-8 text-yellow-600/80" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M19.367 18.102L18 14h-1.5l.833 4H2.667l.833-4H2L.632 18.102C.285 19.146.9 20 2 20h16c1.1 0 1.715-.854 1.367-1.898zM15 5A5 5 0 1 0 5 5c0 4.775 5 10 5 10s5-5.225 5-10zm-7.7.06A2.699 2.699 0 0 1 10 2.361a2.699 2.699 0 1 1 0 5.399 2.7 2.7 0 0 1-2.7-2.7z"></path></svg>
                        <p class="my-2 flex-1">Địa chỉ: A3.05 Sunrise Cityview - 33 Nguyễn Hữu Thọ, P. Tân Hưng, Quận 7, Tp Hồ Chí Minh</p>
                    </li>
                    <li class="flex gap-2 items-center">
                        <svg class="w-8 h-8 text-yellow-600/80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75v-4.5m0 4.5h4.5m-4.5 0l6-6m-3 18c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z"></path>
                          </svg>
                        <p class="my-2">Hotline: 090 258 7745</p>
                    </li>
                    <li class="flex gap-2 items-center">
                        <svg class="w-8 h-8 text-yellow-600/80" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"></path></svg>
                        <p class="my-2">Email: siaginseng@gmail.com</p>
                    </li>
                    <li class="flex gap-2 items-center">
                        <svg class="w-8 h-8 text-yellow-600/80" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 540 480" fill="currentColor"><title>web</title><path d="M270 410q-14-1-25-23-11-22-18-59 21 2 43 2 22 0 43-2-7 37-18 59-11 22-25 23l0 0z m-210-170q2 91 61 149 58 59 149 61 91-2 149-61 59-58 61-149-2-91-61-149-58-59-149-61-91 2-149 61-59 58-61 149l0 0z m40 0q1-14 23-25 22-11 59-18-2 21-2 43 0 22 2 43-37-7-59-18-22-11-23-25l0 0z m8 53q32 20 80 29 9 48 29 80-39-13-68-41-28-29-41-68l0 0z m0-106q13-39 41-68 29-28 68-41-20 32-29 80-48 9-80 29l0 0z m112 53q0-26 2-48 23-2 48-2 26 0 48 2 2 22 2 48 0 25-2 48-22 2-48 2-25 0-48-2-2-23-2-48l0 0z m7-88q7-37 18-59 11-22 25-23 14 1 25 23 11 22 18 59-21-2-43-2-22 0-43 2l0 0z m96 250q20-32 29-80 48-9 80-29-13 39-41 68-29 28-68 41l0 0z m0-324q39 13 68 41 28 29 41 68-32-20-80-29-9-48-29-80l0 0z m35 205q2-21 2-43 0-22-2-43 37 7 59 18 22 11 23 25-1 14-23 25-22 11-59 18l0 0z"></path></svg>
                        <p class="my-2">Website: siaginseng.com</p>
                    </li>
                </ul>
            </div>
            <div class="">
                <form x-data="{}" @submit.prevnet="alert('Tính năng đang phát triển!'); return;"
                    class="mx-4 p-4 lg:p-8 bg-yellow-800/10 border border-yellow-900/10">
                    <h2 class="mt-0 text-center font-bold">Gửi yêu cầu liên hệ cho chúng tôi!</h2>
                    @csrf
                    <input type="text" name="contact_name" placeholder="Họ và Tên" required
                        class="my-2 w-full focus:border border-yellow-800 rounded-lg"/>
                    <input type="text" name="address" placeholder="Địa chỉ" required
                        class="my-2 w-full focus:border border-yellow-800 rounded-lg"/>
                    <input type="text" name="phone" placeholder="Điện thoại" required
                        class="my-2 w-full focus:border border-yellow-800 rounded-lg"/>
                    <input type="email" name="email" placeholder="Email" required
                        class="my-2 w-full focus:border border-yellow-800 rounded-lg"/>
                    <textarea name="message" placeholder="Nội dung" required
                        class="my-2 w-full focus:border border-yellow-800 rounded-lg"></textarea>
                    <button type="submit" class="block py-2 px-8 bg-yellow-800 text-white hover:bg-green-800 transition-all rounded-full uppercase font-bold">Gửi</button>
                </form>
            </div>

        </div>
        <h2 class="my-6 text-center font-bold text-2xl uppercase text-yellow-800">Bản đồ</h2>
        <iframe class="w-full aspect-video" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.8560188179727!2d106.69850497578479!3d10.745578089401349!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f755f679599%3A0xd55e3dc5b7120648!2zU3VucmlzZSBDaXR5IFZpZXcsIMSQLiBOZ3V54buFbiBI4buvdSBUaOG7jSwgVMOibiBIxrBuZywgUXXhuq1uIDcsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCA3MDAwMDAsIFZpZXRuYW0!5e0!3m2!1sen!2s!4v1704868463868!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>


    </div>

@endsection
