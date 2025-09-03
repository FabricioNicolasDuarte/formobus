# TPG01 — Repositorios & Buenas Prácticas

> **Epica:** Módulo de Autenticación y Validación de Usuarios  
> **Flujo:** GitFlow simplificado (main/develop/feature/release/hotfix)  
> **Plataforma:** GitLab (repo privado)

## 0) Objetivos
- Crear y configurar un proyecto en **GitLab**.
- Aplicar **GitFlow** para la épica: *Módulo de Autenticación y Validación de Usuarios*.
- Practicar **Merge Requests** y revisión entre pares.
- Escribir **commits claros y trazables** (Convencional Commits).
- Usar **git stash** correctamente.

---

## 1) Requisitos previos
- Cuenta personal en GitLab.
- Git instalado y configurado:  
  ```bash
  git --version
  git config --global user.name "Tu Nombre"
  git config --global user.email "tu-email@example.com"
  ```
- Editor (VS Code recomendado).

---

## 2) Esquema de ramas (GitFlow)
- `main` → estable/producción
- `develop` → integración
- `feature/*` → nuevas funcionalidades
- `release/*` → preparación de versión
- `hotfix/*` → correcciones urgentes desde `main`

**Comandos base:**
```bash
# Clonar e iniciar develop
git clone <url-del-repo>
cd tpg01-repositorios-buenas-practicas
git checkout -b develop
git push -u origin develop
```

---

## 3) Épica e issues
**Épica:** *Módulo de Autenticación y Validación de Usuarios*  
**Issues sugeridos:**
- #1 Registro de usuarios (`feature/auth-register`)
- #2 Login / Logout (`feature/auth-login`)
- #3 Validación de email / recuperación de contraseña (`feature/auth-verify-email`)
- #4 Middleware de autorización por roles (`feature/auth-roles`)
- #5 Tests mínimos (unitarios/integración) **(no requerido por la cátedra)**

**Flujo para cada issue:**
1. Partir desde `develop`.
2. Crear rama `feature/...`.
3. Commits atómicos y descriptivos.
4. MR → destino `develop`, con descripción + `Closes #N`.
5. Revisión de un compañero (1 aprobación mínima).
6. Al finalizar features: crear `release/0.1.0` desde `develop`.
7. Probar/corregir en `release`.
8. Merge a `main` + **tag** `v0.1.0` y **back-merge** a `develop`.
9. Bug urgente en prod → `hotfix/...` desde `main`, merge a `main` y back-merge a `develop`.

> Si omiten `release/*`, documenten el criterio y hagan `develop → main` cuando esté listo.

---

## 4) Commit Convention (resumen)
Formato:
```
<tipo>(<ámbito opcional>): <resumen en presente, imperativo>

<contexto/motivo breve>
- Punto 1
- Punto 2

Closes #<n> (si cierra issue)
```
Tipos frecuentes: `feat`, `fix`, `docs`, `refactor`, `test`, `chore`, `ci`.

**Ejemplos:**
- `feat(auth): agrega flujo de login`  
  - Se integra validación en backend y formulario en frontend.  
  - Closes #2
- `fix(users): corrige validación de password mínimo 8 chars`  
  - Actualiza schema y tests asociados.  
  - Closes #21
- `fix: resuelve NullPointer al cargar configuración sin .env`
- `fix(auth): repara verificación de token expirado en middleware`

**Evitar:** `arreglos varios`, `cambios`, `fix final`, `subo todo`.

---

## 5) Merge Requests — pasos mínimos
1. **Título:** `feat(auth-login): agrega flujo de login)`
2. **Descripción:** qué cambia, por qué, cómo probar; enlazar `Closes #X`.
3. **Checklist:**
   - [x] Compila
   - [x] Tests pasan (si hay)
   - [x] Sin TODOs críticos
   - [x] README/Docs actualizados
4. Asignar revisor y pedir aprobación.
5. **Squash** recomendado si hubo commits ruidosos (con buen mensaje final).

---

## 6) Manejo de conflictos (simulación)
- Crear dos ramas que editen **la misma línea** del mismo archivo.
- Al mergear, resolver marcas `<<<<<<<`, `=======`, `>>>>>>>`.  
- Probar, `commit` y `push`.
- Documentar brevemente en el MR cómo lo resolvieron.
- Ver guía en `docs/CONFLICT_RESOLUTION.md`.

---

## 7) `git stash` — explicación y práctica
`git stash` guarda **temporalmente** cambios no comprometidos (working dir y/o staged) en una pila, limpia tu árbol para cambiar de rama o actualizar, y permite **recuperarlos** luego.

**Comandos útiles:**
```bash
git stash push -m "WIP: validación de email"   # guarda cambios
git stash list                                 # listar stashes
git stash show -p stash@{0}                    # ver diff
git stash apply stash@{0}                      # aplica y mantiene
git stash pop                                  # aplica y quita de la pila
git stash drop stash@{0}                       # elimina uno
git stash push -k                              # conserva staging
git stash push -u                              # incluye untracked
```
**Ejercicio:** ver `docs/STASH_EXERCISE.md`.

**Cuándo NO usarlo:** para esconder cambios “sucios” antes de un MR. Preferir commits atómicos o una rama WIP.

---

## 8) Bonus (opcional)
- Pipeline simple con **GitLab CI**: ejecutar tests o linter.  
- Convencional Commits + **Commitlint/Husky**.  
- Template de MR: `.gitlab/merge_request_templates/feature.md`.  
- Tagging y releases (`v0.1.0`) en `main`.

---

## 9) Historial de comandos guía
```bash
# Ramas
git checkout -b feature/auth-login
git push -u origin feature/auth-login

# Actualizar develop antes de una feature
git checkout develop && git pull

# Integrar feature a develop (vía MR recomendado)
git checkout develop
git merge --no-ff feature/auth-login

# Release
git checkout -b release/0.1.0 develop

# Tag en main
git checkout main
git merge --no-ff release/0.1.0
git tag v0.1.0
git push origin main --tags

# Hotfix
git checkout -b hotfix/login-crash main
```
---

## 10) Entregables — checklist
- [ ] Link del repo GitLab (privado; profe como *Reporter*).
- [ ] 2 MRs mínimos (uno `feat`, uno `fix`).
- [ ] Captura de pipeline o historial de commits/ramas.
- [ ] **README.md** completo (este archivo).
- [ ] **CONTRIBUTING.md** con reglas de commits y flujo de ramas.
- [ ] Documentación breve del conflicto y del `stash` (en `docs/`).

---

## 11) Licencia
MIT o Apache-2.0 (a elección del equipo).
