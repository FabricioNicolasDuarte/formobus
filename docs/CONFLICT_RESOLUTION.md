# Guía rápida: Resolver un conflicto

1. Crear conflicto (dos ramas editan la **misma línea**):
   ```bash
   git checkout -b conflict/a
   echo "linea-conflictiva" > conflict.txt
   git add conflict.txt && git commit -m "chore: agrega linea conflictiva"
   git push -u origin conflict/a

   git checkout -b conflict/b main
   echo "linea-conflictiva-b" > conflict.txt
   git add conflict.txt && git commit -m "chore: cambia linea conflictiva en B"
   git push -u origin conflict/b
   ```

2. Intentar merge y resolver:
   ```bash
   git checkout conflict/a
   git merge conflict/b
   # Editar conflict.txt y dejar la versión correcta
   git add conflict.txt
   git commit -m "fix: resuelve conflicto en conflict.txt"
   git push
   ```

3. Documentar en el MR:
   - Archivo afectado y motivo del conflicto.
   - Decisión tomada y por qué.
