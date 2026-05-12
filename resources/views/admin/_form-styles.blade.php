<style>
    .form-card {
        background: #fff;
        border: 1px solid #E0E5F2;
        border-radius: 8px;
        padding: 2rem;
    }

    .form-back {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #A3AED0;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 1.5rem;
        transition: color 0.15s;
    }
    .form-back:hover { color: #2D60FF; }

    .form-section {
        padding-top: 1.5rem;
        margin-top: 1.5rem;
        border-top: 1px solid #F4F7FE;
    }

    .form-section-title {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        color: #A3AED0;
        margin-bottom: 1.25rem;
    }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
    @media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }

    .form-field { display: flex; flex-direction: column; gap: 0.4rem; }

    .form-label {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #1B254B;
    }

    .form-input {
        background: #F4F7FE;
        border: 1.5px solid #E0E5F2;
        border-radius: 6px;
        color: #1B254B;
        padding: 0.7rem 0.9rem;
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 500;
        outline: none;
        transition: border-color 0.15s, background 0.15s;
        width: 100%;
        box-sizing: border-box;
    }
    .form-input:focus { border-color: #2D60FF; background: #fff; }
    .form-input::placeholder { color: #A3AED0; font-weight: 400; }

    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
        padding-top: 1.5rem;
        margin-top: 1.5rem;
        border-top: 1px solid #F4F7FE;
    }

    .form-info {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        background: #FFFBEB;
        border: 1px solid #FDE68A;
        border-radius: 6px;
        padding: 0.875rem 1rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: #92400E;
        margin-top: 1.25rem;
    }

    .photo-upload {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #F4F7FE;
    }

    .photo-preview {
        width: 72px; height: 72px;
        border-radius: 8px;
        background: #F4F7FE;
        border: 1.5px dashed #E0E5F2;
        overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        position: relative;
    }

    .photo-label {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #F4F7FE;
        border: 1.5px solid #E0E5F2;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #1B254B;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        transition: border-color 0.15s, color 0.15s;
    }
    .photo-label:hover { border-color: #2D60FF; color: #2D60FF; }

    .toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #F4F7FE;
        border: 1px solid #E0E5F2;
        border-radius: 6px;
        padding: 0.875rem 1.25rem;
    }

    .toggle-label { font-size: 0.825rem; font-weight: 700; color: #1B254B; }
    .toggle-sub   { font-size: 0.72rem;  font-weight: 500; color: #A3AED0; margin-top: 2px; }
</style>
