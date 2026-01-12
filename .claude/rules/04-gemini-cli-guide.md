---
title: Gemini CLI Complete Reference Guide
priority: MEDIUM
audience: AI Agents, Developers
last_updated: 2025-11-25
---

# Gemini CLI Complete Reference Guide

Comprehensive guide for using Gemini CLI in the hybrid workflow for code generation and command execution.

---

## 📋 Overview

**What Is Gemini CLI:**
- AI-powered command-line tool for code generation
- Faster than Claude for boilerplate code (generates in seconds)
- Integrates with Claude Code for hybrid workflow

**When to Use:**
- Generating boilerplate code (repositories, models, tests)
- Running commands autonomously (tests, quality checks)
- Querying codebase information (function lists, class signatures)

**When NOT to Use:**
- Complex business logic (use Claude)
- Architectural decisions (use Claude)
- Security-critical code (use Claude with review)

---

## 🔧 Installation & Setup

### Prerequisites

```bash
# Node.js 18+ required
node --version  # Should be >= 18.0.0

# npm (comes with Node.js)
npm --version
```

### Install Gemini CLI

```bash
# Install globally
npm install -g @google/generative-ai-cli

# Verify installation
gemini --version
```

### Set API Key

**Option 1: Environment Variable (Recommended)**
```bash
# Add to ~/.bashrc or ~/.zshrc
export GEMINI_API_KEY="your-api-key-here"

# Reload shell
source ~/.bashrc  # or source ~/.zshrc
```

**Option 2: Per-Command**
```bash
GEMINI_API_KEY="your-key" gemini -m gemini-2.5-pro "Your prompt"
```

### Get API Key

1. Go to https://aistudio.google.com/apikey
2. Create new API key
3. Copy and save securely

---

## 🌐 Web Search Feature

**🆕 NEW: Built-in web search for research and documentation**

### Syntax

```bash
gemini -m gemini-2.5-pro 'google_web_search(query="your search query")' 2>&1 | grep -v "^\[ERROR\]" | grep -v "^Loaded"
```

**Key Points:**
- Use single quotes around the entire prompt
- Function syntax: `google_web_search(query="search terms")`
- Returns summarized results with citations
- Takes 5-30 seconds depending on complexity

### Basic Examples

**Example 1: Find Documentation**
```bash
gemini -m gemini-2.5-flash 'google_web_search(query="Minio object storage official documentation")' 2>&1 | grep -v "^\[ERROR\]" | grep -v "^Loaded"
```

**Example 2: Library Installation**
```bash
gemini -m gemini-2.5-flash 'google_web_search(query="Claude Agent SDK Python installation guide")' 2>&1 | grep -v "^\[ERROR\]" | grep -v "^Loaded"
```

**Example 3: Best Practices Research**
```bash
gemini -m gemini-2.5-pro 'google_web_search(query="TypeScript Node.js best practices 2025")' 2>&1 | grep -v "^\[ERROR\]" | grep -v "^Loaded"
```

### Advanced: Search + Follow-up Instructions

You can combine web search with additional instructions:

```bash
gemini -m gemini-2.5-flash 'google_web_search(query="Minio TypeScript SDK methods") After finding the documentation, list the top 5 most important methods with brief descriptions.' 2>&1 | grep -v "^\[ERROR\]" | grep -v "^Loaded"
```

### When to Use Web Search

**✅ Good Use Cases:**
- Finding official documentation URLs
- Researching unfamiliar libraries before coding
- Looking up API specifications
- Checking latest versions and breaking changes
- Discovering architectural patterns
- Finding installation instructions

**❌ Don't Use For:**
- Questions Gemini already knows
- Real-time code generation (use standard mode)
- Quick factual queries (ask directly instead)

### Performance Comparison

| Model | Speed | Quality | Best For |
|-------|-------|---------|----------|
| gemini-2.5-flash | 5-10s | Good | Simple queries, quick lookups |
| gemini-2.5-pro | 10-30s | Excellent | Complex research, detailed answers |

### Web Search in Research Workflow

**Complete 3-step research pattern:**

```bash
# Step 1: Web search for documentation
gemini -m gemini-2.5-pro 'google_web_search(query="Redis TypeScript client documentation")' 2>&1 | grep -v "^\[ERROR\]" | grep -v "^Loaded"

# Step 2: Context7 for code patterns
gemini -m gemini-2.5-pro --allowed-mcp-server-names context7 "Search Context7 for Redis client best practices"

# Step 3: Generate code with insights
gemini -m gemini-2.5-pro "@pattern.py Generate RedisClient class following discovered patterns. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

---

## 🎯 Two Operating Modes

Gemini CLI has two distinct modes for different use cases:

###  Mode 1: Standard Mode (SAFE - Code Generation)

**Purpose:** Generate code, output to stdout, Claude reviews before writing

**Command:**
```bash
gemini -m gemini-2.5-pro "Generate code. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**Characteristics:**
- ✅ Outputs code to terminal (stdout)
- ✅ No side effects (doesn't execute commands)
- ✅ Claude reviews 100% before writing files
- ✅ Safe for code generation

**Use Cases:**
- Generate repository classes
- Generate service classes
- Generate model schemas
- Generate test files
- Generate any boilerplate code

**Example:**
```bash
# Generate a FastAPI endpoint
gemini -m gemini-2.5-pro "@app/models.py Generate POST /users endpoint in FastAPI that creates a user with email validation" 2>&1 | grep -v "^\[" | grep -v "^Loaded"

# Output appears in terminal
# Claude reviews the code
# Claude uses Write tool to create file
```

### Mode 2: YOLO Mode (AUTONOMOUS - Command Execution)

**Purpose:** Execute commands automatically, results stored in Gemini's context

**Command:**
```bash
gemini -m gemini-2.5-pro --yolo "Run tests and show results"
```

**Characteristics:**
- ⚠️ Commands execute automatically (no approval)
- ⚠️ Side effects possible (files created, tests run, etc.)
- ✅ Large outputs captured (no truncation)
- ✅ Results stay in Gemini's context for follow-up

**Use Cases:**
- Run tests (pytest, npm test)
- Run quality checks (black, ruff, mypy)
- Run builds
- Execute git commands
- System commands that don't require approval

**Example:**
```bash
# Run pytest and capture results
gemini -m gemini-2.5-pro --yolo "Run pytest with coverage and show detailed results"

# Commands execute automatically
# Output stored in Gemini's context
# Claude can query Gemini for results
```

---

## 📂 File Inclusion Patterns

### Syntax: `@file_path`

Include file contents in prompt using `@` prefix.

### Single File

```bash
gemini -m gemini-2.5-pro "@app/models.py Generate User repository class based on this model"
```

**What Happens:**
1. Gemini reads `app/models.py`
2. Includes file contents in context
3. Generates code based on file

### Multiple Files

```bash
gemini -m gemini-2.5-pro "@app/models.py @app/repositories/base.py Create UserRepository extending BaseRepository for User model"
```

**Pattern:**
- Space-separated `@file` references
- All files loaded into context
- Generate code using all files as reference

### Glob Patterns

```bash
# All Python files in directory
gemini -m gemini-2.5-pro "@app/models/*.py List all Pydantic models and their fields"

# All test files
gemini -m gemini-2.5-pro "@tests/unit/*.py Count total test functions"
```

**Limitations:**
- Some glob patterns may not work (CLI-dependent)
- Better to list files explicitly if glob fails

---

## 💬 Prompt Engineering for Gemini

### Best Practices

**1. Be Specific:**
```bash
# ❌ Vague
gemini -m gemini-2.5-pro "Make a cache"

# ✅ Specific
gemini -m gemini-2.5-pro "@pattern.py Create CacheRepository with async get/set/delete methods using Redis, following this pattern"
```

**2. Request Text Output:**
```bash
# Always include in standard mode
gemini -m gemini-2.5-pro "Generate code. Output as text."
#                                              ^^^^^^^^^^^^^^
```

**3. Include Context:**
```bash
# Reference existing patterns
gemini -m gemini-2.5-pro "@app/repositories/token_repository.py Create CacheRepository following the same pattern as TokenRepository"
```

**4. Specify Format:**
```bash
# Request specific structure
gemini -m gemini-2.5-pro "List all async functions. Format: filename:line_number function_name(args) -> return_type"
```

### Common Prompts

**Code Generation:**
```bash
# Repository class
gemini -m gemini-2.5-pro "@app/models.py @app/repositories/base.py Generate UserRepository for User model with CRUD operations. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"

# Service class
gemini -m gemini-2.5-pro "@app/repositories/user_repository.py Generate UserService with create/get/update/delete methods. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"

# Test file
gemini -m gemini-2.5-pro "@app/services/user_service.py Generate pytest tests for UserService with fixtures and mocks. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**Information Queries:**
```bash
# List functions
gemini -m gemini-2.5-pro "@app/services/ List all async functions and their signatures only" 2>&1 | grep -v "^\[" | grep -v "^Loaded"

# Find dependencies
gemini -m gemini-2.5-pro "@app/ List all external dependencies (imports from external packages)" 2>&1 | grep -v "^\[" | grep -v "^Loaded"

# Class overview
gemini -m gemini-2.5-pro "@app/models/ List all Pydantic models with fields and types" 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**Command Execution (YOLO):**
```bash
# Run tests
gemini -m gemini-2.5-pro --yolo "Run pytest tests/unit/ and show test names and results"

# Quality checks
gemini -m gemini-2.5-pro --yolo "Run black app/ then ruff check app/ then mypy app/ and summarize results"

# Git operations
gemini -m gemini-2.5-pro --yolo "Show git status and list files changed"
```

---

## 🔍 Output Filtering

### Why Filter?

Gemini CLI outputs debug messages that clutter results:
```
[DEBUG] Loading model...
[INFO] Loaded gemini-2.5-pro
Your actual output here
```

### Filter Pattern

```bash
gemini -m gemini-2.5-pro "prompt" 2>&1 | grep -v "^\[" | grep -v "^Loaded"
#                                   ^^^^   ^^^^^^^^^^^   ^^^^^^^^^^^^^^^
#                                   |      Filter [      Filter "Loaded"
#                                   Combine stdout+stderr
```

**What Each Part Does:**
- `2>&1` - Redirect stderr to stdout (capture all output)
- `grep -v "^\["` - Remove lines starting with `[` (debug messages)
- `grep -v "^Loaded"` - Remove lines starting with "Loaded"

### Examples

**Without Filtering:**
```bash
$ gemini -m gemini-2.5-pro "Say hello"
[DEBUG] Initializing client...
[INFO] Loaded gemini-2.5-pro
[INFO] Processing prompt...
Hello! How can I help?
```

**With Filtering:**
```bash
$ gemini -m gemini-2.5-pro "Say hello" 2>&1 | grep -v "^\[" | grep -v "^Loaded"
Hello! How can I help?
```

---

## 📊 Token Optimization

### Information Queries vs Full File Reads

**Problem:** Reading entire files wastes tokens

**Solution:** Query specific information instead

**Example:**

**❌ Inefficient (5000 tokens):**
```bash
# Claude reads entire file to find function signatures
Read("app/services/recipe_service.py")
```

**✅ Efficient (50 tokens):**
```bash
# Gemini extracts just signatures
gemini -m gemini-2.5-pro "@app/services/recipe_service.py List function signatures only. Format: def function_name(args) -> return" 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**Token Savings:** ~90% (5000 → 500 tokens)

### Query Patterns

**1. List Signatures:**
```bash
gemini -m gemini-2.5-pro "@module/ List all function signatures" 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**2. Find Classes:**
```bash
gemini -m gemini-2.5-pro "@module/ List all class names and their methods" 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**3. Extract Imports:**
```bash
gemini -m gemini-2.5-pro "@file.py List all import statements" 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**4. Count Items:**
```bash
gemini -m gemini-2.5-pro "@tests/ Count test functions" 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

---

## ⚙️ Model Selection

### Available Models

```bash
# Recommended: gemini-2.5-pro
gemini -m gemini-2.5-pro "prompt"

# Faster but less capable: gemini-2.5-flash
gemini -m gemini-2.5-flash "prompt"
```

### When to Use Each

**gemini-2.5-pro (DEFAULT):**
- ✅ Code generation (better quality)
- ✅ Complex prompts
- ✅ Multi-file context
- ⏱️ Slower (~5-10s response)

**gemini-2.5-flash:**
- ✅ Simple queries
- ✅ Information extraction
- ✅ Quick responses needed
- ⏱️ Faster (~2-3s response)

---

## 🐛 Troubleshooting

### Error: "API key not found"

**Problem:**
```
Error: GEMINI_API_KEY environment variable not set
```

**Solution:**
```bash
# Check if set
echo $GEMINI_API_KEY

# If empty, set it
export GEMINI_API_KEY="your-key-here"

# Verify
echo $GEMINI_API_KEY
```

### Error: "Command not found: gemini"

**Problem:**
```bash
$ gemini --version
-bash: gemini: command not found
```

**Solution:**
```bash
# Reinstall globally
npm install -g @google/generative-ai-cli

# Check npm global bin path
npm config get prefix
# Should be in your PATH

# If not, add to PATH in ~/.bashrc or ~/.zshrc
export PATH="$PATH:$(npm config get prefix)/bin"
```

### Error: "Rate limit exceeded"

**Problem:**
```
Error: 429 Too Many Requests - Rate limit exceeded
```

**Solution:**
```bash
# Wait 60 seconds
sleep 60

# Or use fallback AI CLI (OpenCode)
opencode run --model amazon-bedrock/qwen.qwen3-coder-30b-a3b-v1:0 "prompt"
```

### Output Truncated

**Problem:** Large outputs cut off in standard mode

**Solution:** Use YOLO mode
```bash
# Standard mode truncates at ~1000 lines
gemini -m gemini-2.5-pro "Run pytest" 2>&1 | grep -v "^\[" | grep -v "^Loaded"

# YOLO mode captures everything
gemini -m gemini-2.5-pro --yolo "Run pytest and show all test results"
```

### No Output / Hanging

**Problem:** Command runs but no output

**Possible Causes:**
1. API key invalid
2. Network issue
3. Model overloaded

**Debug:**
```bash
# Test with simple prompt
gemini -m gemini-2.5-pro "Say hello"

# Check API key
curl "https://generativelanguage.googleapis.com/v1/models?key=$GEMINI_API_KEY"

# Try different model
gemini -m gemini-2.5-flash "Say hello"
```

---

## ✅ Best Practices

### DO ✅

**1. Use for Boilerplate:**
```bash
# Generate repetitive code
gemini -m gemini-2.5-pro "@pattern.py Create 5 similar repository classes following this pattern. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**2. Include Pattern Files:**
```bash
# Reference existing code style
gemini -m gemini-2.5-pro "@app/repositories/user_repository.py Create OrderRepository following same pattern. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**3. Request Specific Output:**
```bash
# Be explicit about format
gemini -m gemini-2.5-pro "List functions. Format: function_name(params) -> return_type" 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**4. Use YOLO for Commands:**
```bash
# Commands that should run automatically
gemini -m gemini-2.5-pro --yolo "Run all quality checks: black, ruff, mypy"
```

**5. Filter Output:**
```bash
# Always filter in standard mode
gemini -m gemini-2.5-pro "prompt" 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

### DON'T ❌

**1. Don't Use for Complex Logic:**
```bash
# ❌ Complex business rules
gemini -m gemini-2.5-pro "Generate algorithm for optimal recipe extraction with error handling and caching strategy"

# ✅ Use Claude instead
# Claude has better reasoning for complex logic
```

**2. Don't Skip Claude Review:**
```bash
# ❌ Write directly from Gemini output
gemini -m gemini-2.5-pro "Generate code" > file.py

# ✅ Claude reviews first
gemini -m gemini-2.5-pro "Generate code. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
# → Claude reviews → Claude uses Write tool
```

**3. Don't Use YOLO for Code Generation:**
```bash
# ❌ YOLO writes files without review
gemini -m gemini-2.5-pro --yolo "Generate UserRepository and write to file"

# ✅ Standard mode for code generation
gemini -m gemini-2.5-pro "Generate UserRepository. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**4. Don't Forget Error Handling:**
```bash
# ❌ No error checking
output=$(gemini -m gemini-2.5-pro "Generate code" 2>&1 | grep -v "^\[" | grep -v "^Loaded")

# ✅ Check for errors
output=$(gemini -m gemini-2.5-pro "Generate code" 2>&1 | grep -v "^\[" | grep -v "^Loaded")
if [ -z "$output" ]; then
    echo "Error: No output from Gemini"
    exit 1
fi
```

**5. Don't Exceed Context Limits:**
```bash
# ❌ Too many files
gemini -m gemini-2.5-pro "@app/**/*.py Generate summary"

# ✅ Specific files
gemini -m gemini-2.5-pro "@app/main.py @app/config.py Generate summary"
```

---

## 📋 Quick Reference Card

### Web Search (Research)
```bash
gemini -m gemini-2.5-pro 'google_web_search(query="search terms")' 2>&1 | grep -v "^\[ERROR\]" | grep -v "^Loaded"
```

### Standard Mode (Code Generation)
```bash
gemini -m gemini-2.5-pro "Generate [code]. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

### YOLO Mode (Command Execution)
```bash
gemini -m gemini-2.5-pro --yolo "Run [command] and show results"
```

### With File Context
```bash
gemini -m gemini-2.5-pro "@file.py Generate code based on this. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

### Information Query
```bash
gemini -m gemini-2.5-pro "@module/ List all [functions/classes/etc]" 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

### Multi-File Context
```bash
gemini -m gemini-2.5-pro "@file1.py @file2.py Generate code using both files. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

---

## 🔗 Related Documentation

- **`workflows/hybrid-workflow.md`** - How Gemini fits in hybrid workflow
- **`workflows/8-step-verification.md`** - Step 2 (code generation with Gemini)
- **`templates/approval-rules-template.md`** - Quality requirements
- **`workflows/gemini-context-persistence.md`** - Session memory management

---

## 📞 Support & Resources

**Official Documentation:**
- Gemini AI Studio: https://aistudio.google.com/
- API Docs: https://ai.google.dev/docs

**Getting Help:**
- Check troubleshooting section above
- Review hybrid-workflow.md for usage patterns
- Consult project-specific coding standards

---

**Version:** 1.0.0
**Last Updated:** 2025-11-25
**Tool Version:** @google/generative-ai-cli (check with `gemini --version`)
