<div class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="text-center">
        <h1 class="display-1 fw-bold text-primary">404</h1>
        <h3 class="mb-3">Oups ! Page introuvable</h3>
        <p class="mb-4 text-muted">
            La page que vous cherchez n’existe pas ou a été déplacée.
        </p>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg">
            ⬅ Retour à la page précédente
        </a>
    </div>
</div>