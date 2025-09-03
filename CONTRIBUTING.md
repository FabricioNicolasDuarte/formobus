# CONTRIBUTING

## Flujo de trabajo
- **GitFlow simplificado**:
  - `main`: producción
  - `develop`: integración
  - `feature/*`: nuevas funcionalidades
  - `release/*`: estabilización y preparación de versión
  - `hotfix/*`: correcciones urgentes desde `main`

## Convencional Commits
```
<tipo>(<ámbito opcional>): <resumen en presente, imperativo>

<contexto/motivo breve>
- Puntos con detalle (si aplica)

Closes #<n>
```
Tipos: `feat`, `fix`, `docs`, `refactor`, `test`, `chore`, `ci`.

**Ejemplos:**
- `feat(auth): agrega flujo de login` — Closes #2
- `fix(users): corrige validación de password mínimo 8 chars` — Closes #21

## Reglas de ramas
- Minúsculas y guiones: `feature/auth-login`, `hotfix/login-crash`.
- Commits **atómicos**.
- Abrir **MR** hacia `develop` (o `main` para hotfix).
- Revisión: al menos **1 aprobación**.
- Usar `Closes #<n>` para enlazar el issue.

## Checklist de MR
- [x] Compila / pasa linters
- [x] Sin TODOs críticos
- [x] Pruebas pasan (si hay)
- [x] Docs/README actualizados

## Conflictos
- Resolver localmente.
- Explicar en el MR cómo se resolvió (archivo y línea afectados).

## Stash
- Usar `git stash` para aparcar trabajo temporal.
- **No** usar para ocultar cambios antes de un MR.
