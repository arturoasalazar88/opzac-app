---
title: 8-Step Verification Process - Complete Guide
priority: HIGH
audience: AI Agents, Developers
last_updated: 2025-11-25
---

# 8-Step Verification Process - Complete Guide

This guide provides a comprehensive walkthrough of the mandatory 8-step verification process that ensures code quality, testing completeness, and proper documentation in AI-assisted development.

---

## 📋 Process Overview

**Purpose:** Ensure every code change meets quality standards and is properly documented

**Who Uses This:** AI agents (Claude Code, Cursor) and developers

**When:** EVERY code change, regardless of size

**Golden Rule:** 🔒 NO CODE IS COMPLETE WITHOUT USER SIGN-OFF

---

## The 8 Steps

```
Step 1: Context7 Review        → Research best practices
Step 2: Plan & Implementation   → Design and code
Step 3: Code Quality           → Format, lint, typecheck
Step 4: Unit Tests             → 100% pass rate
Step 5: Integration Tests      → Real services
Step 6: Self Review            → Manual checklist
Step 7: USER SIGN-OFF          → Present evidence, WAIT
Step 8: Save Session Memory    → Update documentation
```

**Time Investment:** 5-30 minutes per story (varies by complexity)

**Quality Guarantee:** Zero defects, comprehensive testing, complete documentation

---

## Step 1: Context7 Review (MANDATORY)

### What It Is

Context7 is an MCP tool that provides up-to-date best practices and patterns for libraries and frameworks. **NEVER skip this step** - it prevents using outdated patterns from AI training data.

### When to Use

**ALWAYS before writing code** that uses:
- External libraries (FastAPI, React, Django, etc.)
- Frameworks (pytest, jest, etc.)
- Language features you're uncertain about
- New APIs you haven't used recently

### How to Use

**1. Resolve Library ID:**
```
Tool: mcp__context7__resolve-library-id
Input: "fastapi async patterns"
Output: Library ID for Context7 lookup
```

**2. Get Documentation:**
```
Tool: mcp__context7__get-library-docs
Input: Library ID from step 1
Output: Current best practices and patterns
```

**3. Read & Understand:**
- Don't just skim - actually read the patterns
- Note anti-patterns to avoid
- Understand the "why" behind recommendations

**4. Apply in Code:**
- Use patterns from Context7, not from memory
- Reference specific recommendations in comments
- Verify implementation matches guidance

### Examples

**Example 1: FastAPI Endpoint**
```markdown
Before implementing POST /users endpoint:

1. Resolve: "fastapi dependency injection"
2. Get docs: FastAPI request validation patterns
3. Learn: Use Depends() for shared dependencies
4. Apply: Implement with proper dependency injection
```

**Example 2: React Hook**
```markdown
Before using useEffect:

1. Resolve: "react useeffect best practices"
2. Get docs: Hook dependency array patterns
3. Learn: Avoid infinite loops, proper cleanup
4. Apply: Implement with correct dependencies
```

### Common Pitfalls

❌ **Skipping Context7**: "I know FastAPI, I don't need to look it up"
- Reality: Framework best practices evolve, AI training data is outdated

❌ **Quick Skim**: Reading docs but not applying them
- Reality: You'll use outdated patterns anyway

❌ **Partial Lookup**: "I'll just look up this one thing"
- Reality: Missing related patterns creates inconsistencies

### Success Criteria

- ✅ Context7 queried BEFORE writing code
- ✅ Relevant best practices identified
- ✅ Patterns understood and applied
- ✅ Anti-patterns avoided

### Time Investment

**5-10 minutes** - Saves hours of debugging and refactoring

---

## Step 2: Plan & Design + Implementation

### Planning Phase

**Purpose:** Design before coding prevents rework

**Activities:**
1. **Architecture Design** - How does this fit in the system?
2. **Data Model** - What data structures are needed?
3. **API Contract** - What are inputs/outputs?
4. **Integration Points** - What does this connect to?
5. **Error Scenarios** - What can go wrong?

**Example Planning:**
```markdown
Task: Add recipe caching

Architecture:
- CacheRepository handles Redis operations
- RecipeService calls cache before external API
- Cache miss → fetch → store → return

Data Model:
- Key: f"recipe:{url_hash}"
- Value: JSON-serialized recipe dict
- TTL: 7 days (604800 seconds)

API Contract:
- Input: url (str)
- Output: Recipe | None
- Errors: RedisConnectionError, JSONDecodeError

Integration:
- Redis client (existing)
- Recipe API (existing)
- Error logging service
```

### Implementation Phase

**Hybrid Workflow (Recommended):**
1. **Use AI CLI for boilerplate** (Gemini/OpenCode)
   ```bash
   gemini -m gemini-2.5-pro "@pattern.py Generate CacheRepository"
   ```

2. **Claude reviews 100%** of generated code
   - Check Context7 patterns applied
   - Verify error handling
   - Validate security concerns
   - Ensure type safety

3. **Refine with Claude** - Complex logic, business rules
   ```python
   # Claude writes this directly:
   async def _validate_recipe_data(self, data: dict) -> bool:
       """Complex validation logic that AI CLI shouldn't generate."""
       # Business rules, edge cases, security checks
   ```

### Code Quality Standards

**Follow Project Coding Standards:**
- Read `context/06-coding-standards.md`
- Apply patterns from Context7
- Use project-specific conventions
- Match existing code style

**Security Checklist:**
- ✅ Input validation (Pydantic models)
- ✅ SQL injection prevention (parameterized queries)
- ✅ XSS prevention (output escaping)
- ✅ Authentication required (dependency injection)
- ✅ Rate limiting applied
- ✅ No hardcoded secrets

**Performance Checklist:**
- ✅ Async where appropriate
- ✅ Database queries optimized (no N+1)
- ✅ Caching implemented
- ✅ Resource cleanup (context managers)
- ✅ Memory leaks prevented

### Examples

**Example 1: FastAPI Endpoint**
```python
# ✅ GOOD - Follows Context7 patterns
@router.post("/recipes/parse")
async def parse_recipe(
    request: RecipeParseRequest,  # Pydantic validation
    token: dict = Depends(get_current_token),  # Auth via DI
    cache: CacheRepository = Depends(get_cache)  # Service via DI
) -> RecipeResponse:
    # Check cache first
    cached = await cache.get(request.url)
    if cached:
        return RecipeResponse(**cached)

    # Process and cache
    recipe = await process_recipe(request.url)
    await cache.set(request.url, recipe.dict())
    return recipe
```

```python
# ❌ BAD - Ignores patterns
@router.post("/recipes/parse")
def parse_recipe(request):  # Not async, no validation
    token = request.headers.get("token")  # Manual auth
    if not token: raise Exception()  # Poor error handling

    recipe = do_stuff(request.url)  # Sync code
    return recipe  # No caching, no type hints
```

### Common Pitfalls

❌ **Skipping planning**: "I'll figure it out as I code"
- Reality: Leads to refactoring and wasted time

❌ **Not using AI CLI**: "Faster to write it myself"
- Reality: Wastes 40-60% more tokens, loses lessons learned

❌ **Not reviewing AI output**: "AI CLI generated it, must be good"
- Reality: AI makes mistakes, patterns may be outdated

### Success Criteria

- ✅ Architecture designed before coding
- ✅ AI CLI used for boilerplate (if applicable)
- ✅ Claude reviewed 100% of AI-generated code
- ✅ Context7 patterns applied
- ✅ Project coding standards followed
- ✅ Security and performance checked

### Time Investment

**10-30 minutes** - Planning saves hours of refactoring

---

## Step 3: Code Quality Check (Zero Errors Required)

### What It Is

Automated tooling that ensures code formatting, linting, and type checking meet project standards. **Zero tolerance** for errors.

### Tools & Commands

**1. Format Code:**
```bash
# Python
black app/ tests/

# JavaScript/TypeScript
prettier --write src/

# Go
gofmt -w .
```

**2. Lint Code:**
```bash
# Python
ruff check app/ tests/

# JavaScript/TypeScript
eslint src/

# Go
golangci-lint run
```

**3. Type Check:**
```bash
# Python
mypy app/

# TypeScript
tsc --noEmit

# Go
go vet ./...
```

### Success Criteria

**Must achieve:**
- ✅ Zero formatting inconsistencies
- ✅ Zero linting violations
- ✅ Zero type errors
- ✅ All imports resolved
- ✅ No unused variables/imports

### Fixing Errors

**Workflow:**
```bash
# Run all checks
black app/ && ruff check app/ && mypy app/

# If errors found:
# 1. Read error message carefully
# 2. Fix the root cause (don't disable linter)
# 3. Run checks again
# 4. Repeat until 0 errors
```

### Common Errors & Fixes

**Error 1: Import Not Found**
```python
# ❌ Error
from models import User  # mypy: Cannot find module 'models'

# ✅ Fix
from app.models import User  # Use absolute imports
```

**Error 2: Type Mismatch**
```python
# ❌ Error
async def get_user(id: str) -> User:
    return await db.find_one({"_id": id})  # Returns dict, not User

# ✅ Fix
async def get_user(id: str) -> User:
    data = await db.find_one({"_id": id})
    return User(**data)  # Convert dict to User model
```

**Error 3: Unused Import**
```python
# ❌ Error
from fastapi import FastAPI, HTTPException  # HTTPException unused

# ✅ Fix
from fastapi import FastAPI  # Remove unused imports
```

### Common Pitfalls

❌ **Disabling linters**: `# noqa` or `# type: ignore` everywhere
- Reality: Hides real issues, accumulates tech debt

❌ **"I'll fix it later"**: Proceeding with errors
- Reality: Errors compound, harder to fix later

❌ **Manual formatting**: Not using auto-formatters
- Reality: Inconsistent style, wastes review time

### Success Criteria

- ✅ All code formatted automatically
- ✅ Zero linting violations
- ✅ Zero type errors
- ✅ No disabled linter rules (unless explicitly approved)

### Time Investment

**2-5 minutes** - Automated tools are fast

---

## Step 4: Unit Tests (100% Pass Rate Required)

### What It Is

Automated tests that verify individual functions and classes work correctly. **100% pass rate** is non-negotiable.

### Test Types

**1. Success Cases** - Happy path testing
```python
async def test_create_user_success():
    user = await create_user("john@example.com", "password123")
    assert user.email == "john@example.com"
    assert user.id is not None
```

**2. Error Cases** - Validation, edge cases
```python
async def test_create_user_invalid_email():
    with pytest.raises(ValidationError):
        await create_user("invalid-email", "password123")
```

**3. Edge Cases** - Boundary conditions
```python
async def test_create_user_empty_password():
    with pytest.raises(ValidationError):
        await create_user("john@example.com", "")
```

### Coverage Requirements

**Minimum Coverage:**
- Overall: >80% (or project-specific target)
- New code: 100% coverage required
- Critical paths: 100% coverage required

**Check Coverage:**
```bash
# Python
pytest --cov=app --cov-report=html

# JavaScript
npm test -- --coverage

# Go
go test -coverprofile=coverage.out ./...
```

### Writing Good Tests

**Test Structure (AAA Pattern):**
```python
async def test_cache_stores_recipe():
    # Arrange - Set up test data
    url = "https://example.com/recipe"
    recipe = {"title": "Test Recipe"}

    # Act - Execute the function
    await cache.set(url, recipe)

    # Assert - Verify the result
    cached = await cache.get(url)
    assert cached == recipe
```

**Test Names:**
```python
# ✅ GOOD - Descriptive, explains what's tested
async def test_cache_returns_none_when_key_not_found():
    ...

# ❌ BAD - Vague, unclear what's tested
async def test_cache():
    ...
```

### Common Pitfalls

❌ **Commenting out failing tests**: "I'll fix it later"
- Reality: Tests exist for a reason, fix the code or the test

❌ **Testing implementation details**: Testing private methods
- Reality: Tests become brittle, refactoring breaks tests

❌ **No edge case testing**: Only testing happy path
- Reality: Production bugs from untested edge cases

❌ **Flaky tests**: Tests that pass/fail randomly
- Reality: Undermines trust in test suite

### Success Criteria

- ✅ All tests pass (100% pass rate)
- ✅ No skipped tests (unless explicitly approved)
- ✅ Coverage ≥ target (e.g., >80%)
- ✅ New code has 100% coverage
- ✅ Tests are fast (< 1 minute total)
- ✅ No flaky tests

### Time Investment

**10-20 minutes** - Write tests as you code, not after

---

## Step 5: Integration Tests (If Applicable)

### What It Is

Tests that verify components work together correctly with real external services (databases, APIs, caches).

### When to Run

**Required for:**
- Database operations
- External API calls
- Message queues
- Caching layers
- File system operations
- Authentication flows

**Not required for:**
- Pure functions (no external dependencies)
- Simple data transformations
- Utility functions

### Test Scenarios

**1. Real Service Integration:**
```python
@pytest.mark.integration
async def test_cache_integration_with_redis():
    # Uses real Redis instance
    cache = CacheRepository(redis_client)

    await cache.set("test-key", {"data": "value"})
    result = await cache.get("test-key")

    assert result == {"data": "value"}
```

**2. Error Scenarios:**
```python
@pytest.mark.integration
async def test_cache_handles_redis_connection_error():
    # Simulate Redis down
    cache = CacheRepository(unavailable_redis_client)

    result = await cache.get("any-key")
    assert result is None  # Graceful degradation
```

**3. Complete Workflows:**
```python
@pytest.mark.integration
async def test_recipe_extraction_end_to_end():
    # Complete flow: HTTP → Audio → AI → Cache → Response
    response = await client.post("/recipes/parse", json={
        "url": "https://instagram.com/reel/test"
    })

    assert response.status_code == 200
    assert response.json()["ingredients"] is not None
```

### Setup Requirements

**Test Environment:**
```bash
# Start services
docker-compose up -d mongodb redis

# Initialize test data
python scripts/init_test_db.py

# Run integration tests
pytest -m integration
```

### Common Pitfalls

❌ **Using mocks instead of real services**: "Integration tests are slow"
- Reality: Mocked tests don't catch integration bugs

❌ **No cleanup between tests**: Tests interfere with each other
- Reality: Flaky tests, hard to debug

❌ **Testing only success cases**: Ignoring error scenarios
- Reality: Production outages from unhandled errors

### Success Criteria

- ✅ All integration tests pass
- ✅ Real external services used (not mocks)
- ✅ Error scenarios tested
- ✅ No regressions in existing functionality
- ✅ Tests are idempotent (can run multiple times)

### Time Investment

**5-15 minutes** - Depends on test complexity

---

## Step 6: Self Review Checklist

### What It Is

Manual review of your own code before presenting to user. Catches issues automated tools miss.

### Code Quality Checklist

**Architecture:**
- [ ] Follows project patterns?
- [ ] Integrates cleanly with existing code?
- [ ] No circular dependencies?
- [ ] Proper separation of concerns?

**Error Handling:**
- [ ] All error cases handled?
- [ ] Meaningful error messages?
- [ ] Logging implemented?
- [ ] No silent failures?

**Security:**
- [ ] Input validation (Pydantic/validation library)?
- [ ] Authentication required?
- [ ] Rate limiting applied?
- [ ] No hardcoded secrets?
- [ ] SQL injection prevented?
- [ ] XSS prevention (if applicable)?

**Performance:**
- [ ] Async where appropriate?
- [ ] No N+1 queries?
- [ ] Caching implemented?
- [ ] Resource cleanup (context managers)?
- [ ] Memory leaks prevented?

**Documentation:**
- [ ] Complex logic commented?
- [ ] API documentation updated?
- [ ] README updated (if needed)?
- [ ] Architecture diagram updated (if needed)?

**Testing:**
- [ ] All new code has tests?
- [ ] Edge cases covered?
- [ ] Error paths tested?
- [ ] Integration tests pass?

### Review Techniques

**1. Read Code Out Loud:**
- Explain what each function does
- If you can't explain it simply, it's too complex

**2. Imagine Edge Cases:**
- What if input is empty?
- What if service is down?
- What if data is malformed?

**3. Check Against Standards:**
- Open `context/06-coding-standards.md`
- Verify each pattern is followed
- Check anti-patterns are avoided

### Common Issues Found

**Issue 1: Missing Error Handling**
```python
# ❌ Before Self Review
async def get_user(id: str) -> User:
    return await db.find_one({"_id": id})

# ✅ After Self Review
async def get_user(id: str) -> Optional[User]:
    try:
        data = await db.find_one({"_id": id})
        if not data:
            return None
        return User(**data)
    except PyMongoError as e:
        logger.error(f"Database error: {e}")
        raise DatabaseError("Failed to fetch user")
```

**Issue 2: Hardcoded Values**
```python
# ❌ Before Self Review
CACHE_TTL = 604800  # What is this number?

# ✅ After Self Review
CACHE_TTL_SECONDS = 7 * 24 * 60 * 60  # 7 days
```

### Success Criteria

- ✅ All checklist items verified
- ✅ No obvious issues found
- ✅ Code meets project standards
- ✅ Ready to present to user

### Time Investment

**5-10 minutes** - Catches issues before user sees them

---

## Step 7: USER SIGN-OFF (MANDATORY!)

### What It Is

**The Golden Rule:** NO CODE IS COMPLETE WITHOUT EXPLICIT USER APPROVAL

### Present Evidence

**Format:**
```markdown
## Implementation Complete - Ready for Approval

### ✅ Step 1: Context7 Review
- Reviewed: FastAPI dependency injection patterns
- Applied: Depends() for all shared dependencies

### ✅ Step 2: Code Written
- Files created: 2 (cache_repository.py, test_cache.py)
- Lines of code: 247 (AI CLI: 180, Claude: 67)
- Pattern: Gemini boilerplate + Claude refinement

### ✅ Step 3: Code Quality
- black: ✓ All files formatted
- ruff: ✓ 0 violations
- mypy: ✓ 0 type errors

### ✅ Step 4: Unit Tests
- Tests written: 12
- Pass rate: 100% (12/12)
- Coverage: 94% (target: >80%)

### ✅ Step 5: Integration Tests
- Total tests: 4
- All passing: Yes
- Redis integration verified

### ✅ Step 6: Self Review
- Security: Input validation via Pydantic
- Patterns: Async-first, context managers for cleanup
- Error handling: All scenarios covered
- Logging: Implemented for errors and cache hits/misses

**Ready for your approval to proceed with documentation.**
```

### Wait for Response

**⏸️ DO NOT PROCEED** until you receive one of these responses:

**Approved:**
- ✅ "Approved"
- ✅ "Looks good"
- ✅ "LGTM" (Looks Good To Me)
- ✅ "Ship it"
- ✅ "Go ahead"

**Changes Requested:**
- ❌ "Change X" → Make changes, return to appropriate step, present again
- ❌ "Fix Y" → Fix issue, re-run tests, present again
- ❓ "Explain Z" → Provide explanation, continue waiting

**No Response:**
- Wait patiently
- Do NOT assume approval
- Do NOT proceed to Step 8

### Common Pitfalls

❌ **Assuming approval**: "They didn't respond, so it's approved"
- Reality: Violates Golden Rule, wastes effort

❌ **Proceeding before approval**: "I'll just do Step 8 now"
- Reality: User may request changes, wasted documentation effort

❌ **Incomplete evidence**: Missing test results or coverage
- Reality: User can't verify quality, requests more info

### Success Criteria

- ✅ Evidence presented clearly
- ✅ All steps documented
- ✅ User explicitly approved
- ✅ Ready for Step 8

### Time Investment

**1-5 minutes** - Format evidence, present to user, wait

---

## Step 8: Save Session Memory (AFTER APPROVAL ONLY)

### What It Is

**🔒 INVIOLABLE:** Only execute AFTER receiving explicit user approval in Step 7

Documentation updates that preserve knowledge for future sessions.

### Required Updates

**1. CLAUDE.md (STRICT 5-line format):**
```markdown
✅ Story XX: [Title] ([Date])
  - What: [Deliverable in 10 words max]
  - How: [Pattern/Tool/Technology used]
  - Quality: [Test count, pass rate, coverage %]
  - Tech: [Key library/framework with version]
  - Savings: [AI CLI usage %, token reduction]
```

**Example:**
```markdown
✅ Story 12: Recipe Cache Repository (2025-11-20)
  - What: MongoDB cache with 4 methods (get, cache, invalidate, stats)
  - How: Context7 Motor patterns (atomic ops, upsert, TTL indexes)
  - Quality: 8 unit tests, 100% pass, 93% coverage maintained
  - Tech: Motor async MongoDB, ReturnDocument.AFTER
  - Savings: Gemini generated 320 lines (~60% token reduction)
```

**2. context/11-implementation-log.md (COMPREHENSIVE):**

Full details (200-500 lines):
- **Implementation Summary** - What was built
- **Architecture Decisions** - Design choices and trade-offs
- **Code Changes** - Files modified, key functions added
- **Context7 Patterns Applied** - Which best practices used
- **AI CLI Usage** - What was generated vs hand-written
- **Test Coverage** - Test counts, coverage metrics
- **Performance Metrics** - Response times, memory usage
- **Lessons Learned** - What worked, what didn't
- **Token Savings** - Calculated reduction from AI CLI usage
- **Blockers Resolved** - Issues encountered and solutions

**3. stories/XX-story-name.md:**
```markdown
**Status:** Complete
**Completion Date:** 2025-11-20
**Commits:** abc123f, def456g
```

### Documentation Guidelines

**Be Specific:**
```markdown
# ❌ Vague
- Implemented caching

# ✅ Specific
- Implemented Redis-backed cache with 7-day TTL
- Cache keys: f"recipe:{url_hash}"
- Hit rate: 94% in testing
- Response time: 45ms cached vs 2.3s uncached
```

**Quantify Everything:**
- Lines of code: 247 total (180 AI CLI, 67 Claude)
- Token savings: ~60% (estimated 3000 tokens → 1200 tokens)
- Test coverage: 94% (target: >80%)
- Performance: 2.3s → 45ms (51x faster)

**Document Trade-offs:**
```markdown
**Trade-off: Cache Invalidation Strategy**

Considered:
1. TTL-only (chosen) - Simple, predictable
2. Manual invalidation - Complex, error-prone
3. Event-driven - Over-engineered for current scale

Decision: TTL-only (7 days)
Rationale: Recipe content rarely changes, simplicity > control
Risk: Stale data if recipe updated (acceptable for MVP)
```

### CLAUDE.md Token Budget

**Before updating:**
```bash
wc -c CLAUDE.md
# Must be < 25,000 chars
```

**If over budget:**
1. Archive old phases to `context/ARCHIVE-phases-X-Y.md`
2. Compress completed stories (use STRICT template)
3. Move details to `context/11-implementation-log.md`
4. Verify: `wc -c CLAUDE.md` now < 25k

### Common Pitfalls

❌ **Vague summaries**: "Added caching"
- Reality: Loses context, future you won't understand

❌ **No quantification**: Missing test counts, coverage, savings
- Reality: Can't measure effectiveness, can't improve

❌ **Skipping implementation log**: Only updating CLAUDE.md
- Reality: Loses detailed knowledge, can't replicate patterns

❌ **Executing before approval**: Doing Step 8 before Step 7
- Reality: Violates Golden Rule, may waste effort

### Success Criteria

- ✅ CLAUDE.md updated (STRICT 5-line format)
- ✅ context/11-implementation-log.md updated (comprehensive)
- ✅ Story file updated (status, completion date)
- ✅ Token budget maintained (< 25k chars)
- ✅ All decisions documented
- ✅ Lessons learned captured

### Time Investment

**5-10 minutes** - Preserve knowledge for future sessions

---

## 🎯 Complete Workflow Example

**Task:** Implement recipe caching with Redis

### Timeline

```
00:00 - Step 1: Context7 Review (5 min)
  → Query "redis async python patterns"
  → Learn: Use aioredis, connection pooling, TTL

00:05 - Step 2: Plan & Implement (20 min)
  → Design: CacheRepository with get/set/delete
  → Generate: Gemini creates boilerplate (180 lines)
  → Refine: Claude adds error handling (67 lines)

00:25 - Step 3: Code Quality (3 min)
  → black: ✓ formatted
  → ruff: ✓ 0 violations
  → mypy: ✓ 0 errors

00:28 - Step 4: Unit Tests (12 min)
  → Write: 8 tests (success, error, edge cases)
  → Run: 100% pass rate
  → Coverage: 94%

00:40 - Step 5: Integration Tests (8 min)
  → Test: Real Redis connection
  → Test: Error scenarios (connection lost)
  → Result: All pass

00:48 - Step 6: Self Review (5 min)
  → Security: ✓ No hardcoded credentials
  → Patterns: ✓ Async-first, context managers
  → Error handling: ✓ All scenarios covered

00:53 - Step 7: Present & Wait (2 min + user time)
  → Present evidence
  → Wait for "Approved"

00:55 - Step 8: Document (8 min)
  → Update CLAUDE.md (STRICT template)
  → Update implementation log (comprehensive)
  → Update story file

01:03 - COMPLETE! ✅
```

**Total Time:** ~1 hour (varies by complexity)

**Quality:** 100% test pass rate, 94% coverage, all patterns followed

---

## 📊 Success Metrics

**Quality Metrics:**
- Test pass rate: Must be 100%
- Code coverage: Must meet target (e.g., >80%)
- Linter errors: Must be 0
- Type errors: Must be 0

**Efficiency Metrics:**
- Time to implement: Track per story
- AI CLI usage: % of code generated vs hand-written
- Token savings: Measure reduction from AI CLI usage
- First-pass approval rate: % approved without changes

**Process Metrics:**
- Steps completed: 8/8 required
- Documentation completeness: Checklist verified
- Context budget: CLAUDE.md size / 25k chars

---

## ⚠️ Common Anti-Patterns

**Process Violations:**
- ❌ Skipping Context7 (Step 1) - Leads to outdated patterns
- ❌ Not using AI CLI (Step 2) - Wastes 40-60% more tokens
- ❌ Proceeding with test failures (Step 4) - Breaks quality guarantee
- ❌ Assuming approval (Step 7) - Violates Golden Rule
- ❌ Executing Step 8 before Step 7 - Wastes documentation effort

**Quality Shortcuts:**
- ❌ Disabling linters to hide issues (Step 3)
- ❌ Commenting out failing tests (Step 4)
- ❌ Using mocks instead of real services (Step 5)
- ❌ Skipping self-review checklist (Step 6)

**Documentation Failures:**
- ❌ Vague summaries (Step 8) - "Added caching"
- ❌ Missing quantification (Step 8) - No test counts or coverage
- ❌ Exceeding CLAUDE.md budget (Step 8) - Degrades performance

---

## 🎯 Quick Reference

**Before Every Code Change:**
1. Query Context7 for best practices
2. Use AI CLI for boilerplate
3. Claude reviews 100% of code

**After Every Code Change:**
3. Run quality checks (0 errors required)
4. Run unit tests (100% pass required)
5. Run integration tests (if applicable)
6. Complete self-review checklist
7. Present evidence, WAIT for approval
8. Update documentation (AFTER approval)

**Remember:** Quality over speed. Patient iteration over rushing.

---

**Version:** 1.0.0
**Last Updated:** 2025-11-25
**Applies To:** All code changes, no exceptions
