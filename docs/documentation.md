# Documentation Guidelines

## Core principle: progressive disclosure

- Root instruction files (`CLAUDE.md`, `AGENTS.md`) contain only
  the minimum rules needed to prevent observed mistakes.
- Detailed guidance lives in `docs/` and is loaded on-demand via @imports. This
  respects context window limits — agents reliably follow ~100–150 instructions
  total, so every line in the root file competes with the actual task for attention.
- When deciding where something belongs: if it prevents a frequent mistake,
  it goes in `CLAUDE.md`; everything else goes in `docs/`.

## Repository documentation structure

```
project-root/
├── CLAUDE.md          — Agent instructions (<100 lines). @imports to docs/.
├── AGENTS.md          — Cross-tool agent instructions (or symlinked from CLAUDE.md).
├── README.md          — Human-facing: purpose, setup, usage, contributing.
└── docs/              — Detailed docs for humans and agents.
```

## CLAUDE.md

Purpose: only directives that prevent concrete, observed agent mistakes.

- Use imperative, unambiguous statements. No explanations of "why".
- Never add obvious facts inferable from code (language, framework, file structure).
- Commands section: exact flags and full syntax, never paraphrased.
- Do not duplicate rules already enforced by linters, formatters, or hooks.
- Reference detailed docs via `@docs/filename.md` — don't inline large blocks.
- When adding a new rule, verify it doesn't repeat an existing one.

## AGENTS.md, GEMINI.md and others

Purpose: cross-tool agent instructions readable by Copilot, Cursor, Codex, Aider, Windsurf and others.

Keep `CLAUDE.md` tool-agnostic. Tool-specific overrides go in their own config
files (`.cursor/rules/`, `.github/copilot-instructions.md`, etc.) or are symlinked
from `CLAUDE.md`.

## README.md

Purpose: human-oriented project overview. Not for agent instructions.

Should contain:
- Project purpose (one paragraph).
- Quick start / installation with exact commands.
- Basic usage examples.
- Tech stack with version numbers.
- Directory structure overview (if non-obvious).
- Links to `docs/` for detailed topics.

Should not contain:
- Agent-specific instructions (those belong in `CLAUDE.md).
- Badges, shields, or boilerplate sections not explicitly requested.
- Paraphrased commands — always use exact, copy-pasteable strings.
- Contributing guidelines go to `CONTRIBUTING.md`.

## docs/ directory

Purpose: detailed documentation loaded on-demand by both humans and agents.

### File organization
- One topic per file. Use descriptive filenames: `architecture.md`,
  `testing-guide.md`, `api-patterns.md` — not `notes.md` or `misc.md`.
- Do not create docs files unless asked or content exceeds what fits inline.
- Do not create README files inside docs/ subdirectories unless asked.

### Writing for dual readability (human + AI)
- Write primarily for humans. Good human docs are good AI docs.
- Keep related constraints close to their implementation guidance — AI chunking
  separates scattered information.
- Make all implicit knowledge explicit. If it's not written down, it doesn't exist
  for agents.
- Include specific names (features, modules, APIs, functions) for semantic
  discoverability.
- Avoid layout-dependent information (merged table headers, multi-column
  comparisons that break without visual layout).
- Provide text equivalents for any visual content (diagrams, screenshots).

### Cross-referencing
- From `CLAUDE.md`, use `@docs/filename.md` imports for progressive disclosure.
- Within docs/, use relative markdown links between files.
- Keep a flat structure unless the project genuinely needs subdirectories.
