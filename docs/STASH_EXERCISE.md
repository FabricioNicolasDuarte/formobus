# Ejercicio obligatorio — git stash

**Objetivo:** practicar stash en `feature/auth-verify-email`.

1. Crear/entrar a la rama:
   ```bash
   git checkout -b feature/auth-verify-email develop
   ```
2. Editar **dos archivos** (sin commitear).
3. Guardar cambios:
   ```bash
   git stash push -m "WIP verify-email"
   ```
4. Cambiar a `develop` y actualizar:
   ```bash
   git checkout develop && git pull
   ```
5. Volver y recuperar:
   ```bash
   git checkout feature/auth-verify-email
   git stash pop     # o: git stash apply stash@{0}
   ```
6. Continuar y commitear con un mensaje correcto:
   ```bash
   git add .
   git commit -m "feat(auth): implementa verificación de email y recuperación de cambios del stash"
   git push -u origin feature/auth-verify-email
   ```

**Notas**
- Usar `git stash list`, `git stash show -p` para inspeccionar.
- `git stash push -u` para incluir archivos no trackeados.
