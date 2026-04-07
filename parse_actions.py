import os
import glob

views_dir = 'resources/views'
modules = ['subscriptions', 'clients', 'domains', 'payments', 'credentials', 'roles', 'expenses', 'sales', 'contacts', 'users', 'servers', 'projects', 'tickets', 'audit-logs', 'applications']

for module in modules:
    index_path = os.path.join(views_dir, module, 'index.blade.php')
    if os.path.exists(index_path):
        with open(index_path, 'r') as f:
            content = f.read()
            has_can = '@can' in content
            has_destroy = 'destroy' in content or 'DELETE' in content
            print(f"{module.ljust(15)} : Has @can? {has_can} | Has Destroy Form? {has_destroy}")
