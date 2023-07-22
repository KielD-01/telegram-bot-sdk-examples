@props([
    'actions' => null,
    'ariaLabelledby' => null,
    'closeButton' => true,
    'closeByClickingAway' => true,
    'closeEventName' => 'close-modal',
    'darkMode' => false,
    'displayClasses' => 'inline-block',
    'footer' => null,
    'header' => null,
    'heading' => null,
    'headingComponent' => 'filament-support::modal.heading',
    'hrComponent' => 'filament-support::hr',
    'id' => null,
    'openEventName' => 'open-modal',
    'scrollableContent' => false,
    'slideOver' => false,
    'subheading' => null,
    'subheadingComponent' => 'filament-support::modal.subheading',
    'trigger' => null,
    'visible' => true,
    'width' => 'sm',
])

<div
    x-data="{
        isOpen: false,

        livewire: null,

        close: function () {
            this.isOpen = false

            this.$refs.modalContainer.dispatchEvent(
                new CustomEvent('modal-closed', { id: '{{ $id }}' }),
            )
        },

        open: function () {
            this.isOpen = true

            this.$refs.modalContainer.dispatchEvent(
                new CustomEvent('modal-opened', { id: '{{ $id }}' }),
            )
        },
    }"
    x-trap.noscroll="isOpen"
    @if ($id)
        x-on:{{ $closeEventName }}.window="if ($event.detail.id === '{{ $id }}') close()"
        x-on:{{ $openEventName }}.window="if ($event.detail.id === '{{ $id }}') open()"
    @endif
    @if ($ariaLabelledby)
        aria-labelledby="{{ $ariaLabelledby }}"
    @elseif ($heading)
        aria-labelledby="{{ "{$id}.heading" }}"
    @endif
    role="dialog"
    aria-modal="true"
    class="filament-modal {{ $displayClasses }}"
    wire:ignore.self
>
    {{ $trigger }}

    <div
        x-show="isOpen"
        x-transition.duration.300ms.opacity
        x-cloak
        @class([
            'fixed inset-0 z-40 min-h-full overflow-y-auto overflow-x-hidden transition',
            'flex items-center' => ! $slideOver,
        ])
    >
        <div
            @if ($closeByClickingAway)
                @if (filled($id))
                    x-on:click="$dispatch('{{ $closeEventName }}', { id: '{{ $id }}' })"
                @else
                    x-on:click="close()"
                @endif
            @endif
            aria-hidden="true"
            @class([
                'filament-modal-close-overlay fixed inset-0 h-full w-full bg-black/50',
                'cursor-pointer' => $closeByClickingAway,
            ])
        ></div>

        <div
            x-ref="modalContainer"
            {{
                $attributes->class([
                    'pointer-events-none relative w-full cursor-pointer transition',
                    'my-auto p-4' => ! $slideOver,
                    'flex max-h-screen shrink' => $scrollableContent,
                ])
            }}
        >
            <div
                x-data="{ isShown: false }"
                x-init="
                    $nextTick(() => {
                        isShown = isOpen
                        $watch('isOpen', () => (isShown = isOpen))
                    })
                "
                x-show="isShown"
                x-cloak
                @if (filled($id))
                    x-on:keydown.window.escape="$dispatch('{{ $closeEventName }}', { id: '{{ $id }}' })"
                @else
                    x-on:keydown.window.escape="close()"
                @endif
                x-transition:enter="ease duration-300"
                x-transition:leave="ease duration-300"
                @if ($slideOver)
                    x-transition:enter-start="translate-x-full rtl:-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full rtl:-translate-x-full"
                @elseif ($width !== 'screen')
                    x-transition:enter-start="translate-y-8"
                    x-transition:enter-end="translate-y-0"
                    x-transition:leave-start="translate-y-0"
                    x-transition:leave-end="translate-y-8"
                @endif
                @class([
                    'filament-modal-window pointer-events-auto w-full cursor-default bg-white py-2',
                    'dark:bg-gray-800' => $darkMode,
                    'relative' => $width !== 'screen',
                    'ml-auto mr-0 h-screen overflow-y-auto rtl:ml-0 rtl:mr-auto' => $slideOver,
                    'mx-auto rounded-xl' => ! ($slideOver || ($width === 'screen')),
                    'hidden' => ! $visible,
                    'max-w-xs' => $width === 'xs',
                    'max-w-sm' => $width === 'sm',
                    'max-w-md' => $width === 'md',
                    'max-w-lg' => $width === 'lg',
                    'max-w-xl' => $width === 'xl',
                    'max-w-2xl' => $width === '2xl',
                    'max-w-3xl' => $width === '3xl',
                    'max-w-4xl' => $width === '4xl',
                    'max-w-5xl' => $width === '5xl',
                    'max-w-6xl' => $width === '6xl',
                    'max-w-7xl' => $width === '7xl',
                    'fixed inset-0' => $width === 'screen',
                ])
            >
                @if ($closeButton)
                    <button
                        tabindex="-1"
                        type="button"
                        class="absolute right-2 top-2 rtl:left-2 rtl:right-auto"
                        @if (filled($id))
                            x-on:click="$dispatch('{{ $closeEventName }}', { id: '{{ $id }}' })"
                        @else
                            x-on:click="close()"
                        @endif
                    >
                        <x-heroicon-s-x
                            class="filament-modal-close-button h-4 w-4 cursor-pointer text-gray-400"
                            :title="__('filament-support::components/modal.actions.close.label')"
                            tabindex="-1"
                        />

                        <span class="sr-only">
                            {{ __('filament-support::components/modal.actions.close.label') }}
                        </span>
                    </button>
                @endif

                <div
                    @class([
                        'flex h-full flex-col' => ($width === 'screen') || $slideOver || $scrollableContent,
                    ])
                >
                    <div class="space-y-2">
                        @if ($header)
                            <div class="filament-modal-header px-6 py-2">
                                {{ $header }}
                            </div>
                        @endif

                        @if ($header && ($actions || $heading || $slot->isNotEmpty() || $subheading))
                            <x-dynamic-component
                                :component="$hrComponent"
                                :dark-mode="$darkMode"
                                class="px-2"
                            />
                        @endif
                    </div>

                    <div
                        @class([
                            'filament-modal-content space-y-2 p-2',
                            'flex-1 overflow-y-auto' => ($width === 'screen') || $slideOver || $scrollableContent,
                        ])
                    >
                        @if ($heading || $subheading)
                            <div
                                @class([
                                    'space-y-2 p-4',
                                    'text-center' => ! $slideOver,
                                    'dark:text-white' => $darkMode,
                                ])
                            >
                                @if ($heading)
                                    <x-dynamic-component
                                        :component="$headingComponent"
                                        :id="$id . '.heading'"
                                    >
                                        {{ $heading }}
                                    </x-dynamic-component>
                                @endif

                                @if ($subheading)
                                    <x-dynamic-component
                                        :component="$subheadingComponent"
                                    >
                                        {{ $subheading }}
                                    </x-dynamic-component>
                                @endif
                            </div>
                        @endif

                        @if ($slot->isNotEmpty())
                            <div class="space-y-4 px-4 py-2">
                                {{ $slot }}
                            </div>
                        @endif

                        {{ $actions }}
                    </div>

                    <div class="space-y-2">
                        @if ($footer && ($actions || $heading || $slot->isNotEmpty() || $subheading))
                            <x-dynamic-component
                                :component="$hrComponent"
                                :dark-mode="$darkMode"
                                class="px-2"
                            />
                        @endif

                        @if ($footer)
                            <div class="filament-modal-footer px-6 py-2">
                                {{ $footer }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
