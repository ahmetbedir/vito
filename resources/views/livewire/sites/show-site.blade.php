<div>
    @if($site->status === \App\Enums\SiteStatus::INSTALLING)
        @include('livewire.sites.partials.installing', ['site' => $site])
    @endif
    @if($site->status === \App\Enums\SiteStatus::INSTALLATION_FAILED)
        @include('livewire.sites.partials.installation-failed', ['site' => $site])
    @endif
    @if($site->status === \App\Enums\SiteStatus::READY)
        <div class="space-y-10">
            @include('livewire.sites.partials.site-overview', ['site' => $site])
        </div>
    @endif
</div>