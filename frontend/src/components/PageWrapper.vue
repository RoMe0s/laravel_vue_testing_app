<template>
    <div>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold leading-tight text-gray-900">
                    <slot name="title"></slot>
                </h2>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Replace with your content -->
                <div class="px-4 py-6 sm:px-0">
                    <slot name="content"></slot>
                </div>
            </div>
            <!-- /End replace -->
        </main>
    </div>
</template>