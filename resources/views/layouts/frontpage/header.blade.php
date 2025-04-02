<!-- Navigation -->
<flux:header 
    container 
    sticky 
    class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700"
>
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
    
    <!-- Brand Logos -->
    <flux:brand 
        href="{{route('frontpage')}}" 
        logo="{{asset(setting('site_logo', '#'))}}"  
        class="max-lg:hidden dark:hidden" 
    />
    <flux:brand 
        href="{{route('frontpage')}}" 
        logo="{{asset(setting('site_logo', '#'))}}"  
        class="max-lg:hidden! hidden dark:flex" 
    />
    
    <!-- Navbar -->
    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="home" href="#" current>Home</flux:navbar.item>
        <flux:navbar.item icon="inbox" badge="12" href="#">Inbox</flux:navbar.item>
        <flux:navbar.item icon="document-text" href="#">Documents</flux:navbar.item>
        <flux:navbar.item icon="calendar" href="#">Calendar</flux:navbar.item>
        <flux:separator vertical variant="subtle" class="my-2" />
        
        <!-- Dropdown -->
        <flux:dropdown class="max-lg:hidden">
            <flux:navbar.item icon:trailing="chevron-down">Favorites</flux:navbar.item>
            <flux:navmenu>
                <flux:navmenu.item href="#">Marketing site</flux:navmenu.item>
                <flux:navmenu.item href="#">Android app</flux:navmenu.item>
                <flux:navmenu.item href="#">Brand guidelines</flux:navmenu.item>
            </flux:navmenu>
        </flux:dropdown>
    </flux:navbar>
    
    <flux:spacer />
    
    <!-- Navbar Right -->
    <flux:navbar class="me-4">
        <div class="relative">
            <flux:navbar.item icon="shopping-cart" href="{{ route('cart.index') }}" label="Cart" />
            @php
                $cartSummary = app(\App\Services\CartService::class)->getCartSummary();
                $itemCount = $cartSummary['item_count'] ?? 0;
            @endphp
            <span id="cartBadge" class="cart-badge absolute -top-2 -right-2 bg-yellow-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" style="{{ $itemCount > 0 ? '' : 'display: none;' }}">
                {{ $itemCount }}
            </span>
        </div>
    </flux:navbar>
    
    <!-- Profile Dropdown -->
    <flux:dropdown position="top" align="start">
        <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />
        <flux:menu>
            <flux:menu.radio.group>
                <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                <flux:menu.radio>Truly Delta</flux:menu.radio>
            </flux:menu.radio.group>
            <flux:menu.separator />
            <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
        </flux:menu>
    </flux:dropdown>
</flux:header>

<!-- Sidebar -->
<flux:sidebar 
    stashable 
    sticky 
    class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700"
>
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
    
    <!-- Brand Logos -->
    <flux:brand 
        href="#" 
        logo="{{asset(setting('site_logo', '#'))}}" 
        name="{{asset(setting('site_name', 'StaySnap'))}}" 
        class="px-2 dark:hidden" 
    />
    <flux:brand 
        href="#" 
        logo="{{asset(setting('site_logo', '#'))}}" 
        name="{{asset(setting('site_name', 'StaySnap'))}}" 
        class="px-2 hidden dark:flex" 
    />
    
    <!-- Sidebar Navigation -->
    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="#" current>Home</flux:navlist.item>
        <flux:navlist.item icon="inbox" badge="12" href="#">Inbox</flux:navlist.item>
        <flux:navlist.item icon="document-text" href="#">Documents</flux:navlist.item>
        <flux:navlist.item icon="calendar" href="#">Calendar</flux:navlist.item>
        
        <!-- Expandable Group -->
        <flux:navlist.group expandable heading="Favorites" class="max-lg:hidden">
            <flux:navlist.item href="#">Marketing site</flux:navlist.item>
            <flux:navlist.item href="#">Android app</flux:navlist.item>
            <flux:navlist.item href="#">Brand guidelines</flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>
    
    <flux:spacer />
    
    <!-- Sidebar Footer -->
    <flux:navlist variant="outline">
        <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
        <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item>
    </flux:navlist>
</flux:sidebar>