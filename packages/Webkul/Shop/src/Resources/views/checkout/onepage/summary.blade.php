<!-- Header -->
<h1 class="text-2xl font-medium max-md:py-4 max-md:text-base">
    @lang('shop::app.checkout.onepage.summary.cart-summary')
</h1>

<!-- Cart Items -->
<div class="mt-10 grid border-b border-zinc-200 max-md:mt-3 max-sm:mt-0">
    <div
        class="flex gap-x-4 pb-5 max-md:gap-x-3 max-md:pb-4"
        v-for="item in cart.items"
    >
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.before') !!}

        <img
            class="h-[90px] max-h-[90px] w-[90px] max-w-[90px] rounded-xl max-md:h-20 max-md:max-h-20 max-md:max-w-20 max-md:rounded-lg"
            :src="item.base_image.small_image_url"
            :alt="item.name"
            width="110"
            height="110"
        />

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.after') !!}

        <div>
            {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.before') !!}

            <p class="text-base text-navyBlue max-md:text-sm max-md:font-medium">
                @{{ item.name }}
            </p>

            {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.after') !!}

            <p class="mt-2.5 flex flex-col text-lg font-medium max-md:mt-1 max-md:text-base max-md:font-normal max-sm:text-sm">
                <template v-if="displayTax.prices == 'including_tax'">
                    @lang('shop::app.checkout.onepage.summary.price_and_qty', ['price' => '@{{ item.formatted_price_incl_tax }}', 'qty' => '@{{ item.quantity }}'])
                </template>

                <template v-else-if="displayTax.prices == 'both'">
                    @lang('shop::app.checkout.onepage.summary.price_and_qty', ['price' => '@{{ item.formatted_price_incl_tax }}', 'qty' => '@{{ item.quantity }}'])

                    <span class="text-xs font-normal">
                        @lang('shop::app.checkout.onepage.summary.excl-tax')

                        <span class="font-medium">@{{ item.formatted_total }}</span>
                    </span>
                </template>

                <template v-else>
                    @lang('shop::app.checkout.onepage.summary.price_and_qty', ['price' => '@{{ item.formatted_price }}', 'qty' => '@{{ item.quantity }}'])
                </template>
            </p>
        </div>
    </div>
</div>

<!-- Cart Totals -->
<div class="mb-8 mt-6 grid gap-4 max-md:mb-0 max-sm:mt-4 max-sm:gap-2.5">
    <!-- Sub Total -->
    {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.before') !!}

    <template v-if="displayTax.subtotal == 'including_tax'">
        <div class="flex justify-between text-right">
            <p class="text-base max-sm:text-sm">
                @lang('shop::app.checkout.onepage.summary.sub-total')
            </p>

            <p class="text-base font-medium max-sm:text-sm">
                @{{ cart.formatted_sub_total_incl_tax }}
            </p>
        </div>
    </template>

    <template v-else-if="displayTax.subtotal == 'both'">
        <div class="flex justify-between text-right">
            <p class="text-base max-sm:text-sm">
                @lang('shop::app.checkout.onepage.summary.sub-total-excl-tax')
            </p>

            <p class="text-base font-medium max-sm:text-sm">
                @{{ cart.formatted_sub_total }}
            </p>
        </div>

        <div class="flex justify-between text-right">
            <p class="text-base max-sm:text-sm">
                @lang('shop::app.checkout.onepage.summary.sub-total-incl-tax')
            </p>

            <p class="text-base font-medium max-sm:text-sm">
                @{{ cart.formatted_sub_total_incl_tax }}
            </p>
        </div>
    </template>

    <template v-else>
        <div class="flex justify-between text-right">
            <p class="text-base max-sm:text-sm">
                @lang('shop::app.checkout.onepage.summary.sub-total')
            </p>

            <p class="text-base font-medium max-sm:text-sm">
                @{{ cart.formatted_sub_total }}
            </p>
        </div>
    </template>

    {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.after') !!}

    <!-- Discount -->
    {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.before') !!}

    <div
        class="flex justify-between text-right"
        v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0"
    >
        <p class="text-base max-sm:text-sm">
            @lang('shop::app.checkout.onepage.summary.discount-amount')
        </p>

        <p class="text-base font-medium max-sm:text-sm">
            @{{ cart.formatted_discount_amount }}
        </p>
    </div>

    {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.after') !!}

    <!-- Apply Coupon -->
    {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.before') !!}

    @include('shop::checkout.coupon')

    {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.after') !!}

    <!-- Shipping Rates -->
    {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.before') !!}

    <template v-if="displayTax.shipping == 'including_tax'">
        <div class="flex justify-between text-right">
            <p class="text-base max-sm:text-sm">
                @lang('shop::app.checkout.onepage.summary.delivery-charges')
            </p>

            <p class="text-base font-medium max-sm:text-sm">
                @{{ cart.formatted_shipping_amount_incl_tax }}
            </p>
        </div>
    </template>

    <template v-else-if="displayTax.shipping == 'both'">
        <div class="flex justify-between text-right">
            <p class="text-base max-sm:text-sm">
                @lang('shop::app.checkout.onepage.summary.delivery-charges-excl-tax')
            </p>

            <p class="text-base font-medium max-sm:text-sm">
                @{{ cart.formatted_shipping_amount }}
            </p>
        </div>

        <div class="flex justify-between text-right">
            <p class="text-base max-sm:text-sm">
                @lang('shop::app.checkout.onepage.summary.delivery-charges-incl-tax')
            </p>

            <p class="text-base font-medium max-sm:text-sm">
                @{{ cart.formatted_shipping_amount_incl_tax }}
            </p>
        </div>
    </template>

    <template v-else>
        <div class="flex justify-between text-right">
            <p class="text-base max-sm:text-sm">
                @lang('shop::app.checkout.onepage.summary.delivery-charges')
            </p>

            <p class="text-base font-medium max-sm:text-sm">
                @{{ cart.formatted_shipping_amount }}
            </p>
        </div>
    </template>

    {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.after') !!}


    <!-- Taxes -->
    {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.before') !!}

    <div
        class="flex justify-between text-right"
        v-if="! cart.tax_total"
    >
        <p class="text-base max-md:font-normal max-sm:text-sm">
            @lang('shop::app.checkout.onepage.summary.tax')
        </p>

        <p class="text-lg font-semibold max-sm:text-sm">
            @{{ cart.formatted_tax_total }}
        </p>
    </div>

    <div
        class="flex flex-col gap-2 border-y py-2"
        v-else
    >
        <div
            class="flex cursor-pointer justify-between text-right"
            @click="cart.show_taxes = ! cart.show_taxes"
        >
            <p class="text-base max-md:font-normal max-sm:text-sm">
                @lang('shop::app.checkout.onepage.summary.tax')
            </p>

            <p class="flex items-center gap-1 text-base font-medium max-sm:text-sm">
                @{{ cart.formatted_tax_total }}

                <span
                    class="text-xl"
                    :class="{'icon-arrow-up': cart.show_taxes, 'icon-arrow-down': ! cart.show_taxes}"
                ></span>
            </p>
        </div>

        <div
            class="flex flex-col gap-1"
            v-show="cart.show_taxes"
        >
            <div
                class="flex justify-between gap-1 text-right"
                v-for="(amount, index) in cart.applied_taxes"
            >
                <p class="text-sm max-md:font-normal">
                    @{{ index }}
                </p>

                <p class="text-sm font-medium">
                    @{{ amount }}
                </p>
            </div>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.after') !!}

    <!-- Cart Grand Total -->
    {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.before') !!}

    <div class="flex justify-between text-right">
        <p class="text-lg font-semibold max-sm:text-sm">
            @lang('shop::app.checkout.onepage.summary.grand-total')
        </p>

        <p class="text-lg font-semibold max-sm:text-sm">
            @{{ cart.formatted_grand_total }}
        </p>
    </div>

    {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.after') !!}

    <div
        {{--v-if="cart.payment_method && (typeof cart.payment_method === 'object' ? cart.payment_method.method === 'moneytransfer' : cart.payment_method === 'moneytransfer')"
        class="mt-4 p-4 border border-dashed border-zinc-300 rounded-xl bg-zinc-50"--}}
        v-show="cart.payment_method && (cart.payment_method.method === 'moneytransfer' || cart.payment_method === 'moneytransfer')"
        class="mt-4 p-4 border border-dashed border-zinc-300 rounded-xl bg-zinc-50"
        style="display: none;"
    >
        <div class="grid gap-4">
            <p class="text-sm font-bold text-navyBlue uppercase tracking-wide">
                @lang('Datos de la Transferencia')
            </p>

            <div class="grid gap-1.5">
                <label class="text-[11px] font-bold uppercase text-zinc-600 required">
                    @lang('Banco de Origen')
                </label>
                <select
                    v-model="cart.bank_name"
                    class="block w-full py-2 px-3 border border-zinc-200 rounded-lg text-sm bg-white focus:border-navyBlue focus:ring-0 outline-none"
                >
                    <option value="">@lang('Seleccione un banco')</option>
                    <option value="Banesco">Banesco</option>
                    <option value="Mercantil">Mercantil</option>
                    <option value="Provincial">Provincial</option>
                    <option value="BDV">Banco de Venezuela</option>
                    <option value="Otro">Otro / Pago Móvil</option>
                </select>
            </div>

            <div class="flex gap-4">
                <div class="grid gap-1.5 w-1/2">
                    <label class="text-[11px] font-bold uppercase text-zinc-600 required">
                        @lang('Referencia')
                    </label>
                    <input
                        type="text"
                        v-model="cart.bank_reference"
                        class="block w-full py-2 px-3 border border-zinc-200 rounded-lg text-sm focus:border-navyBlue focus:ring-0 outline-none"
                        placeholder="Ej: 001234"
                    >
                </div>

                <div class="grid gap-1.5 w-1/2">
                    <label class="text-[11px] font-bold uppercase text-zinc-600 required">
                        @lang('Monto Pagado')
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        v-model="cart.bank_amount"
                        class="block w-full py-2 px-3 border border-zinc-200 rounded-lg text-sm focus:border-navyBlue focus:ring-0 outline-none"
                        :placeholder="cart.grand_total"
                    >
                </div>
            </div>

            <span
                v-if="!cart.bank_reference || !cart.bank_name || !cart.bank_amount"
                class="text-[10px] text-red-600 font-medium bg-red-50 p-2 rounded-md border border-red-100"
            >
            <i class="icon-information text-sm"></i>
            @lang('Todos los campos de pago son obligatorios para procesar su orden.')
        </span>
        </div>
    </div>

</div>
