<form>
    <div class="md:mx-6 flex items-center gap-4">
        <input type="number" value="1" min="1" max="100" class="rounded-lg"/>
        @includeIf('coreshop::guest.elements.add_to_cart_button.simple')
    </div>
</form>
