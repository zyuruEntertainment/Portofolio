<section class="dashboard-section">
    <div class="dashboard-section-heading">
        <div>
            <p class="eyebrow">Admin / Social Media</p>
            <h1 class="dashboard-title">Social media.</h1>
            <p class="dashboard-description">
                Manage the social links shown across your portfolio.
            </p>
        </div>
        <a class="primary-button" href="{{ route('admin.social-links.create') }}">Add link</a>
    </div>

    @if ($links->isEmpty())
        <p class="social-links-empty">No social links yet.</p>
    @else
        <div class="social-link-list">
            @foreach ($links as $link)
                <article class="social-link-row" tabindex="0">
                    <div class="social-link-info">
                        <span class="social-link-logo" aria-hidden="true">
                            @include('partials.social-logo', ['platform' => $link->platform, 'valid' => $link->isValid()])
                        </span>
                        <span class="social-link-name">{{ strtoupper($link->platform) }}</span>
                    </div>
                    <div class="social-link-actions">
                        <a class="ghost-button" href="{{ route('admin.social-links.edit', $link) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.social-links.destroy', $link) }}"
                              data-confirm="Remove this social link?">
                            @csrf @method('DELETE')
                            <button class="ghost-button" type="submit">Remove</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</section>
