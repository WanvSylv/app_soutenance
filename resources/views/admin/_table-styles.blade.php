<style>
    .page-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .page-desc { font-size: 0.825rem; font-weight: 500; color: #A3AED0; margin: 0; }

    .alert-success {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        border-radius: 8px;
        padding: 0.75rem 1.25rem;
        font-size: 0.825rem;
        font-weight: 600;
        color: #16A34A;
        margin-bottom: 1.25rem;
    }

    .data-card {
        background: #fff;
        border: 1px solid #E0E5F2;
        border-radius: 8px;
        overflow: hidden;
    }

    .data-table { width: 100%; border-collapse: collapse; }

    .data-table thead tr { background: #F4F7FE; border-bottom: 1px solid #E0E5F2; }

    .data-table th {
        padding: 0.75rem 1.25rem;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #A3AED0;
        white-space: nowrap;
        text-align: left;
    }

    .data-table td {
        padding: 0.9rem 1.25rem;
        border-bottom: 1px solid #F4F7FE;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover { background: #FAFBFF; }

    .row-identity { display: flex; align-items: center; gap: 0.75rem; }

    .avatar {
        width: 32px; height: 32px;
        border-radius: 6px;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .row-name  { font-size: 0.825rem; font-weight: 700; color: #1B254B; }
    .row-sub   { font-size: 0.7rem;   font-weight: 500; color: #A3AED0; margin-top: 1px; }
    .row-text  { font-size: 0.825rem; font-weight: 600; color: #1B254B; }
    .row-muted { font-size: 0.8rem;   font-weight: 500; color: #A3AED0; }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.65rem;
        border-radius: 4px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        white-space: nowrap;
    }
    .badge-blue  { background: #EFF6FF; color: #2D60FF; }
    .badge-green { background: #F0FDF4; color: #16A34A; }
    .badge-amber { background: #FFFBEB; color: #D97706; }
    .badge-red   { background: #FFF5F5; color: #DC2626; }

    .row-actions { display: flex; align-items: center; justify-content: flex-end; gap: 0.4rem; }

    .action-btn {
        width: 30px; height: 30px;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid;
        cursor: pointer;
        transition: background 0.15s, border-color 0.15s;
        text-decoration: none;
        background: transparent;
    }
    .action-edit    { color: #2D60FF; border-color: #DBEAFE; }
    .action-edit:hover { background: #EFF6FF; border-color: #BFDBFE; }
    .action-delete  { color: #DC2626; border-color: #FEE2E2; }
    .action-delete:hover { background: #FFF5F5; border-color: #FECACA; }
    .action-success { color: #16A34A; border-color: #BBF7D0; }
    .action-success:hover { background: #F0FDF4; border-color: #86EFAC; }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        padding: 3rem;
        font-size: 0.825rem;
        font-weight: 600;
        color: #A3AED0;
    }

    .table-pagination { padding: 1rem 1.25rem; border-top: 1px solid #F4F7FE; }

    .table-filter-label {
        display: block;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #A3AED0;
        margin-bottom: 0.4rem;
    }
    .table-filter-input {
        width: 100%;
        background: #F4F7FE;
        border: 1.5px solid #E0E5F2;
        border-radius: 6px;
        color: #1B254B;
        padding: 0.6rem 0.9rem;
        font-family: inherit;
        font-size: 0.825rem;
        font-weight: 500;
        outline: none;
        transition: border-color 0.15s;
    }
    .table-filter-input:focus { border-color: #2D60FF; background: #fff; }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: transparent;
        color: #1B254B;
        border: 1.5px solid #E0E5F2;
        border-radius: 6px;
        font-family: inherit;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0.6rem 1.25rem;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        transition: border-color 0.15s, color 0.15s;
        text-decoration: none;
    }
    .btn-outline:hover { border-color: #2D60FF; color: #2D60FF; }
</style>
