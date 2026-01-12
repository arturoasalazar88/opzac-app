# Gemini CLI Context Persistence Strategy

---
**Purpose:** Maintain ephemeral context within Claude sessions, reset between sessions
**Applies To:** All Gemini CLI sub-agent interactions
**Status:** Mandatory
**Version:** 1.0.0
---

## Overview

Gemini CLI is **stateless** between command executions. However, we can maintain ephemeral session context using Gemini's `save_memory` tool to improve efficiency within a single Claude Code session, then clean up at session boundaries.

## Core Principles

1. **Ephemeral by Design** - Context persists only within active Claude session
2. **Explicit Memory** - Claude instructs Gemini what to remember
3. **Mandatory Cleanup** - Context cleared at session end
4. **Session Isolation** - Each new Claude session starts fresh

## Context Persistence Architecture

```
┌─────────────────────────────────────────────────────────────┐
│ Claude Code Session (Active)                                │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  Gemini Call #1:                                            │
│  Claude: "Remember: This project uses FastAPI 0.121.2"     │
│  Gemini: [Saves to memory via save_memory tool]            │
│                                                             │
│  Gemini Call #2:                                            │
│  Claude: "Generate endpoint using the FastAPI version"     │
│  Gemini: [Recalls FastAPI 0.121.2 from memory]             │
│                                                             │
│  Gemini Call #3:                                            │
│  Claude: "Generate another endpoint"                       │
│  Gemini: [Still remembers FastAPI 0.121.2]                 │
│                                                             │
│  Session End:                                               │
│  Claude: "Clean up Gemini memory"                          │
│  Gemini: [Clears all saved memories]                       │
│                                                             │
└─────────────────────────────────────────────────────────────┘
        ↓ Session Ends, New Session Begins ↓
┌─────────────────────────────────────────────────────────────┐
│ Claude Code Session (New)                                   │
├─────────────────────────────────────────────────────────────┤
│  Gemini: [Fresh start, no previous memories]               │
└─────────────────────────────────────────────────────────────┘
```

## When to Use Context Persistence

### ✅ Use Within Session For:

**Project-Specific Information:**
- Framework versions (FastAPI 0.121.2, Python 3.11.14)
- Key dependencies and their versions
- Coding style preferences (black, ruff, mypy)
- Database schema patterns
- API endpoint conventions
- Test framework setup (pytest, fixtures)

**Current Task Context:**
- Story being worked on (Story 15)
- Current implementation pattern
- File locations being modified
- Recent decisions made
- Integration points identified

**Session Configuration:**
- Working directory
- Environment settings
- Active branch name
- Test commands

**Examples:**
```bash
# Claude tells Gemini to remember at session start
gemini "Remember: This is a FastAPI 0.121.2 project using Python 3.11.14. We use async/await patterns, Motor for MongoDB, and pytest for testing. Code style: black, ruff, mypy."

# Later in session, Gemini recalls this automatically
gemini "@app/services/new_service.py Generate service class following project patterns"
# Gemini uses remembered FastAPI version, async patterns, etc.
```

### ❌ Do NOT Persist Between Sessions:

**Temporary Session State:**
- Intermediate code snippets
- Temporary variable names
- One-off debugging info
- Session-specific decisions

**Security-Sensitive Info:**
- API keys or secrets
- Database credentials
- User personal data
- Production URLs

**Frequently Changing Info:**
- Current story number (changes every session)
- Active bugs being fixed
- Temporary file paths
- Work-in-progress code

## Session Workflow Protocol

### Phase 1: Session Initialization (2-3 min)

**At the START of every Claude Code session:**

```bash
# Step 1: Initialize Gemini with project context
gemini -m gemini-2.5-pro "Remember the following project information for this session:

PROJECT: [Project Name]
LANGUAGE: [Primary language and version]
FRAMEWORK: [Framework and version]
KEY PATTERNS:
- [Pattern 1]
- [Pattern 2]
- [Pattern 3]

CODING STANDARDS:
- Formatter: [black/prettier/etc]
- Linter: [ruff/eslint/etc]
- Type Checker: [mypy/typescript/etc]

TEST FRAMEWORK: [pytest/jest/etc]
DATABASE: [MongoDB/PostgreSQL/etc with version]

CURRENT TASK: Working on [Story XX / Bug YY]

Confirm you have saved this context."
```

**Gemini Response:**
```
I have saved this context for our session. Ready to generate code following these patterns.
```

### Phase 2: Active Development (Variable Duration)

**During the session, Gemini automatically recalls saved context:**

```bash
# No need to repeat project info - Gemini remembers
gemini "@app/models/example.py Generate similar model for Recipe"
# Gemini uses remembered patterns, versions, standards

gemini "Generate pytest test for the Recipe model"
# Gemini uses remembered test framework, async patterns
```

**Add to context as needed:**
```bash
gemini "Remember: Recipe model has 5 required fields and uses Pydantic v2 validation"

# Later...
gemini "Generate validation tests for Recipe model"
# Gemini recalls the 5 required fields
```

### Phase 3: Session Cleanup (1 min) - MANDATORY

**At the END of every Claude Code session:**

```bash
# Step 1: Clear ALL Gemini memories
gemini -m gemini-2.5-pro "Forget everything you remembered this session. Clear all saved memories. This session is ending."

# Step 2: Verify cleanup
gemini -m gemini-2.5-pro "What project information do you remember?"
# Expected: "I don't have any saved project information."
```

**Why This Matters:**
- Prevents context pollution between sessions
- Ensures fresh start for new work
- Avoids stale information affecting future code generation
- Maintains session isolation

## Mandatory Cleanup Rules

### Rule 1: ALWAYS Clean Up at Session End

**🔒 INVIOLABLE:** Before closing Claude Code or ending your work session, ALWAYS run the cleanup protocol.

**Triggers:**
- End of workday
- Switching to different project
- Completing a major task
- Before git commits
- Before pull requests

**Cleanup Command:**
```bash
gemini -m gemini-2.5-pro "CLEANUP: Forget all memories from this session. Clear all saved context. Session ending."
```

### Rule 2: Verify Cleanup Succeeded

**After cleanup, verify:**
```bash
gemini -m gemini-2.5-pro "List all memories you currently have saved."
```

**Expected Response:**
```
I have no saved memories. Starting fresh.
```

**If Gemini still has memories:**
```bash
# Force clear again
gemini -m gemini-2.5-pro "URGENT: Delete ALL saved memories immediately. Confirm deletion."
```

### Rule 3: Never Persist Sensitive Data

**Forbidden to Remember:**
- ❌ API keys, secrets, passwords
- ❌ Database credentials
- ❌ User personal information
- ❌ Production URLs or endpoints
- ❌ Security tokens
- ❌ Private repository data

**If Accidentally Saved:**
```bash
# Immediate cleanup
gemini -m gemini-2.5-pro "SECURITY ALERT: Forget ALL memories immediately, especially any credentials or sensitive data. Delete everything."
```

### Rule 4: Session Boundary Detection

**Automatic Cleanup Triggers:**

If Claude detects any of these, trigger cleanup:
- User says "goodbye", "done", "end session"
- User closes IDE/terminal
- 2+ hours of inactivity
- Switching git branches
- User explicitly requests new session

**Claude Should Ask:**
```
"Session ending. Should I clean up Gemini's memory? (Recommended: Yes)"
```

## Context Persistence Strategies

### Strategy 1: Minimal Context (Recommended for Short Tasks)

**When:** Single story, < 2 hours, straightforward implementation

**What to Save:**
- Framework + version
- Current task identifier
- Key pattern to follow

**Example:**
```bash
gemini "Remember: FastAPI 0.121 async patterns, working on Story 15 test generation"
```

### Strategy 2: Rich Context (Recommended for Complex Tasks)

**When:** Multiple stories, architectural work, > 2 hours, complex integrations

**What to Save:**
- Full tech stack with versions
- Multiple patterns and standards
- Integration points
- Current task + dependencies
- Recent decisions made

**Example:**
```bash
gemini "Remember for this session:
- FastAPI 0.121.2 + Python 3.11.14
- MongoDB via Motor (async), Redis for caching
- Patterns: Repository pattern, dependency injection via Depends()
- Standards: black, ruff, mypy (all must pass)
- Current: Story 15 - Unit Test Expansion
- Context: Following pytest-asyncio patterns, 90% coverage target
- Recent decision: Using pytest fixtures over class-based tests"
```

### Strategy 3: Progressive Context (Recommended for Discovery Tasks)

**When:** Exploratory work, refactoring, debugging, learning new patterns

**What to Save:**
- Start with minimal context
- Add discoveries as you learn
- Build up context progressively

**Example:**
```bash
# Initial
gemini "Remember: Debugging Story 12 cache issue, MongoDB repository pattern"

# After discovery
gemini "Also remember: Cache uses TTL indexes, expires_at field, 7-day default TTL"

# After more discovery
gemini "Also remember: Bug was upsert vs insert, fixed with update_one + upsert=True"
```

## Integration with 8-Step Verification

**Step 1: Context7 Review**
- Claude researches best practices
- Claude tells Gemini: "Remember these Context7 patterns: [list]"

**Step 2: Code Generation**
- Gemini recalls Context7 patterns automatically
- Generates code using remembered standards

**Step 3-6: Quality & Testing**
- Gemini recalls test framework from session init
- Can generate tests using remembered patterns

**Step 7: User Approval**
- No Gemini interaction typically

**Step 8: Session Memory**
- If session continues: Keep Gemini context
- If session ends: **MANDATORY CLEANUP**

## Troubleshooting

### Problem: Gemini Generates Code in Wrong Style

**Cause:** Didn't initialize session context or wrong version remembered

**Solution:**
```bash
# Check what Gemini remembers
gemini "What project conventions do you remember?"

# If wrong, clear and re-initialize
gemini "Forget all memories and remember: [correct project info]"
```

### Problem: Gemini Forgets Mid-Session

**Cause:** Gemini's memory has limits (rare but possible)

**Solution:**
```bash
# Re-save critical context
gemini "Quick reminder: [key patterns and versions]"
```

### Problem: Cleanup Not Working

**Cause:** Gemini not responding to forget command

**Solution:**
```bash
# Multiple cleanup attempts
gemini "Delete all saved memories"
gemini "Clear all context"
gemini "Forget everything"
gemini "Reset to fresh state"

# Verify each time until clean
```

### Problem: Context Pollution Between Sessions

**Cause:** Forgot to run cleanup at previous session end

**Solution:**
```bash
# Start new session with explicit clear
gemini "URGENT: Clear ALL previous session memories before we begin. Confirm when done."

# Wait for confirmation, then initialize fresh
gemini "Remember for this NEW session: [current project info]"
```

## Best Practices

### Do's ✅

1. **Initialize at session start** - Set up project context first thing
2. **Be explicit** - Tell Gemini exactly what to remember
3. **Verify memory** - Ask Gemini to confirm what it remembers
4. **Clean up religiously** - Never skip end-of-session cleanup
5. **Progressive addition** - Add context as you discover patterns
6. **Use for efficiency** - Remember patterns to avoid repetition

### Don'ts ❌

1. **Don't persist sensitive data** - Ever
2. **Don't skip cleanup** - Causes context pollution
3. **Don't over-remember** - Keep it focused on current work
4. **Don't rely on memory between sessions** - Always start fresh
5. **Don't assume memory persists** - Verify Gemini remembers
6. **Don't remember temporary decisions** - Only stable patterns

## Session Template

**Copy-paste this at session start:**

```bash
# ========================================
# GEMINI SESSION INITIALIZATION
# ========================================
gemini -m gemini-2.5-pro "Remember for this session:

PROJECT: [Your Project Name]
TECH STACK:
- [Language]: [version]
- [Framework]: [version]
- [Database]: [version]
- [Key Library]: [version]

PATTERNS:
- [Critical pattern 1]
- [Critical pattern 2]

STANDARDS:
- Format: [tool]
- Lint: [tool]
- Types: [tool]

CURRENT TASK: [Story XX / Bug YY - Brief description]

Confirm you have saved this."

# ========================================
# ... Do your work ...
# ========================================

# ========================================
# GEMINI SESSION CLEANUP (END OF SESSION)
# ========================================
gemini -m gemini-2.5-pro "Session ending. Forget ALL memories. Clear all saved context. Confirm cleanup complete."

# Verify cleanup
gemini -m gemini-2.5-pro "What do you remember?"
# Expected: "I have no saved memories."
```

## Metrics & Monitoring

**Track These:**
- Sessions with proper initialization: Target 100%
- Sessions with proper cleanup: Target 100%
- Context pollution incidents: Target 0
- Average context items per session: Target 5-10

**Red Flags:**
- ⚠️  Gemini generating code in wrong style → Check initialization
- ⚠️  Gemini asking for same info repeatedly → Memory not working
- ⚠️  Code patterns inconsistent → Context pollution from old session

## Integration with Sub-Agent Role

**Update to Gemini Sub-Agent Role:**

Add this section:

```markdown
## Session Memory Management

### At Session Start
You will receive initialization instructions from Claude:
- Save project tech stack and versions
- Save coding standards and patterns
- Save current task context

Use your `save_memory` tool to persist this information.

### During Session
Automatically recall saved context when generating code.
No need for Claude to repeat initialization info.

### At Session End
Claude will instruct you to forget all memories.
Immediately clear all saved context using memory tools.

Confirm cleanup is complete.
```

## Compliance Checklist

**Before Starting Work:**
- [ ] Gemini initialized with project context
- [ ] Gemini confirmed memory saved
- [ ] Session-specific patterns defined

**During Work:**
- [ ] Gemini recalls context correctly
- [ ] Add new discoveries to context as needed
- [ ] Verify Gemini follows remembered patterns

**Before Ending Session:**
- [ ] Run cleanup command
- [ ] Verify memories cleared
- [ ] Confirm Gemini has no saved context

**Audit (Weekly):**
- [ ] Review session initialization compliance
- [ ] Check cleanup success rate
- [ ] Identify any context pollution issues

---

**Version:** 1.0.0
**Last Updated:** 2025-01-24
**Status:** Mandatory Protocol
**Review Cycle:** Monthly
