<div class="cart" data-url="{{ route('deleteCart') }}">
    @if ($carts != NULL)
        <table class="mt-3 lg:mt-10 mb-5 update_cart_url" data-url="{{ route('updateCart') }}">
            <thead>
                <tr class="border-b border-gray-400">
                    <td class="w-1/4 px-1 text-center">Sản phẩm</td>
                    <td class="w-1/4 px-1 text-center">Số lượng</td>
                    <td class="w-1/4 px-1 text-center">Tổng tiền</td>
                    <td class="w-1/4 px-1 text-center">Chỉnh sửa</td>
                </tr>
            </thead>
            @php
                $total = 0;
            @endphp
            <tbody>
                @foreach ($carts as $id => $cart)
                    @php
                        if ($cart['promoID'] != null) {
                            $total += $cart['pricePromo'] * $cart['quantity'];
                        } else {
                            $total += $cart['priceRoot'] * $cart['quantity'];
                        }
                    @endphp
                    <tr id="{{ $id }}">
                        <td class="w-1/4 px-1 text-center"><img
                                src="{{ asset('storage/product') . '/' . $cart['linkImg'] }}" alt=""
                                class="w-10 h-10 lg:w-2/3 lg:h-auto"></td>
                        <td class="w-1/4 px-1 text-center">
                            <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1 ">
                                <button data-action="decrement" type="button"
                                    class="cart_update bg-green-primary text-white hover:bg-green-primary_1 h-full w-20 rounded-l cursor-pointer outline-none">
                                    <span class="m-auto text-2xl font-thin">−</span>
                                </button>
                                <input type="number"
                                    class="focus:outline-none text-center w-full bg-gray-50 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-black outline-none quantity"
                                    name="amount" min="1" value="{{ $cart['quantity'] }}">
                                <button data-action="increment" type="button"
                                    class="cart_update bg-green-primary text-white hover:bg-green-primary_1 h-full w-20 rounded-r cursor-pointer">
                                    <span class="m-auto text-2xl font-thin">+</span>
                                </button>
                            </div>
                        </td>
                        <td class="w-1/4 px-1 text-center">
                            @if ($cart['promoID'] != null)
                                <p>{{ number_format($cart['pricePromo'] * $cart['quantity']) }}</p>
                                <u class="text-green-primary text-center">VND</u>
                            @else
                                <p>{{ number_format($cart['priceRoot'] * $cart['quantity']) }}</p>
                                <u class="text-green-primary text-center">VND</u>
                            @endif

                        </td>
                        <td class="w-1/4 px-1 text-center">
                            <a onclick="return confirm('Bạn có chắc là muốn xóa sản phẩm này?')" href=""
                                data-id="{{ $id }}" class="active text-red-500 cart_delete"
                                ui-toggle-class="">
                                <i class="fa fa-times text-danger text-red-500"></i>
                            </a>
                        </td>
                    </tr>
                    <tr class="text-xl text-gray-500 border-b border-gray-400 mb-10">
                        <td class="pt-5" colspan="4">{{ $cart['name'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex border-b border-gray-400 mb-5">
            <div class="w-1/2 text-2xl text-gray-500">Tổng tiền</div>
            <div id="totalBill" class="w-1/2 text-right">
                <p>{{ number_format($total) }} </p><u class="text-green-primary">VND</u>
            </div>
        </div>
        <div class="py-3 pl-4 lg:pl-10 mt-2 bg-gray-100 text-2xl text-black border-l-4 border-green-primary">
            THÔNG TIN ĐẶT HÀNG
        </div>
        <div class="pl-6 lg:pl-10 pt-5 flex-col pb-4 lg:pb-10">
            <div class="flex w-full">
                <div class="text-left pr-5">
                    <input id="typePay0" checked type="radio" name="typePay" onclick="displayDetailTypePay()">
                </div>
                <div class="">Chuyển khoản ngân hàng</div>
            </div>
            <div id="radioDetail0" class="text full">
                Thực hiện thanh toán vào một trong các tài khoản ngân hàng bên cạnh của chúng tôi. Vui lòng sử dụng mã đơn hàng để thanh toán (VD: thanh toan don hang so 1234)
            </div>
            <div class="flex w-full">
                <div class="text-left pr-5">
                    <input id="typePay1" type="radio" name="typePay" onclick="displayDetailTypePay()">
                </div>
                <div class="">Trả tiền khi nhận mặt hàng</div>
            </div>
            <div id="radioDetail1" class="text">
                Trả tiền mặt khi giao hàng
            </div>
        </div>

        <button class="py-2 px-5 mb-2 items-center justify-center rounded-md bg-green-primary border-2 border-green-primary text-white hover:bg-white hover:text-green-primary" type="submit">
            <a href="">Đặt hàng</a>
        </button>
        <div class="text-red-500 pt-3 pb-20">(Tư vấn viên sẽ gọi điện xác nhận, không mua không sao)</div>
    @else
        <div class="bg-gray-100 text-green-primary_1 text-xl font-semibold flex justify-around items-center text-center p-10 my-5">
            <i class="fas fa-exclamation-circle"></i> Chưa có sản phẩm nào trong giỏ hàng.
        </div>
        <button class="py-2 px-5 mb-2 mx-auto items-center flex justify-around rounded-md bg-green-primary border-2 border-green-primary text-white hover:bg-white hover:text-green-primary">
            <a href="{{ route('productList') }}" class="font-semibold text-lg">Quay về trang sản phẩm</a>
        </button>
    @endif
    
</div>
<script>
    function decrement(e) {
        const btn = e.target.parentNode.parentElement.querySelector(
            'button[data-action="decrement"]'
        );
        const target = btn.nextElementSibling;
        let value = Number(target.value);
        value--;
        if (value <= 0) {
            target.value = 1;
        } else {
            target.value = value;
        }
    }

    function increment(e) {
        const btn = e.target.parentNode.parentElement.querySelector(
            'button[data-action="decrement"]'
        );
        const target = btn.nextElementSibling;
        let value = Number(target.value);
        value++;
        target.value = value;
    }
    onLoad();
    function onLoad() {
        const decrementButtons = document.querySelectorAll(
            `button[data-action="decrement"]`
        );

        const incrementButtons = document.querySelectorAll(
            `button[data-action="increment"]`
        );

        decrementButtons.forEach(btn => {
            btn.addEventListener("click", decrement);
        });

        incrementButtons.forEach(btn => {
            btn.addEventListener("click", increment);
        });
    }
</script>
<script>
    function displayDetailTypePay(){
        var r0 = document.getElementById("typePay0");
        var r1 = document.getElementById("typePay1");
        var text0 = document.getElementById('radioDetail0');
        var text1 = document.getElementById('radioDetail1');
        if(r0.checked == true){
            text0.classList.add('full');
            text1.classList.remove('full');
        }
        if(r1.checked == true){
            text0.classList.remove('full');
            text1.classList.add('full');
        }
    }
    
</script>
