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
Task: Add reservation caching

Architecture:
- CacheService handles Redis/file cache operations
- ReservationController checks cache before database
- Cache miss → query → store → return

Data Model:
- Key: "reservation:{tour_id}:{date}"
- Value: JSON-serialized reservation collection
- TTL: 1 hour (3600 seconds)

API Contract:
- Input: tour_id (int), date (string)
- Output: Collection<Reservation> | null
- Errors: QueryException, CacheException

Integration:
- Redis cache (existing)
- MySQL database (existing)
- Laravel Log facade
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
   ```php
   // Claude writes this directly:
   private function validateReservationData(array $data): bool
   {
       // Complex validation logic that AI CLI shouldn't generate
       // Business rules, edge cases, security checks
   }
   ```

### Code Quality Standards

**Follow Project Coding Standards:**
- Read `context/06-coding-standards.md`
- Apply patterns from Context7
- Use project-specific conventions
- Match existing code style

**Security Checklist:**
- ✅ Input validation (Form Requests / Validator)
- ✅ SQL injection prevention (Eloquent ORM / parameterized queries)
- ✅ XSS prevention (Blade {{ }} escaping)
- ✅ Authentication required (middleware / guards)
- ✅ Rate limiting applied (throttle middleware)
- ✅ No hardcoded secrets (use .env)

**Performance Checklist:**
- ✅ Eager loading where appropriate (no N+1)
- ✅ Database queries optimized (indexes, limits)
- ✅ Caching implemented (Redis/file cache)
- ✅ Resource cleanup (database connections)
- ✅ Queue jobs for heavy operations

### Examples

**Example 1: Laravel Controller**
```php
// ✅ GOOD - Follows Context7 patterns
public function store(ReservationRequest $request): JsonResponse
{
    // Request is validated via Form Request
    $validated = $request->validated();

    // Check cache first
    $cacheKey = "reservation:{$validated['tour_id']}";
    if ($cached = Cache::get($cacheKey)) {
        return response()->json($cached);
    }

    // Process and cache
    $reservation = $this->reservationService->create($validated);
    Cache::put($cacheKey, $reservation->toArray(), 3600);

    return response()->json($reservation, 201);
}
```

```php
// ❌ BAD - Ignores patterns
public function store(Request $request)
{
    $token = $request->header('token');  // Manual auth
    if (!$token) throw new \Exception();  // Poor error handling

    $reservation = Reservation::create($request->all());  // No validation
    return $reservation;  // No caching, no response formatting
}
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
# PHP (Laravel Pint - official formatter)
./vendor/bin/pint

# JavaScript/TypeScript
prettier --write resources/js/

# Or use PHP-CS-Fixer directly
./vendor/bin/php-cs-fixer fix app/
```

**2. Lint Code:**
```bash
# PHP (PHPStan with Larastan for Laravel)
./vendor/bin/phpstan analyse app/

# JavaScript/TypeScript
eslint resources/js/

# PHP syntax check (quick validation)
find app/ -name "*.php" -exec php -l {} \;
```

**3. Static Analysis / Type Check:**
```bash
# PHP (PHPStan - like mypy for PHP)
./vendor/bin/phpstan analyse --level=max app/

# Or use Psalm with Laravel plugin
./vendor/bin/psalm

# TypeScript
tsc --noEmit
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
# Run all checks (Laravel)
./vendor/bin/pint && ./vendor/bin/phpstan analyse app/

# If errors found:
# 1. Read error message carefully
# 2. Fix the root cause (don't disable linter)
# 3. Run checks again
# 4. Repeat until 0 errors
```

### Common Errors & Fixes

**Error 1: Class Not Found**
```php
// ❌ Error
use Models\User;  // Class 'Models\User' not found

// ✅ Fix
use App\User;  // Use correct namespace (App\ for Laravel)
```

**Error 2: Type Mismatch**
```php
// ❌ Error
public function getUser(string $id): User
{
    return DB::table('users')->find($id);  // Returns stdClass, not User
}

// ✅ Fix
public function getUser(string $id): User
{
    return User::findOrFail($id);  // Returns Eloquent model
}
```

**Error 3: Unused Import**
```php
// ❌ Error
use Illuminate\Http\Request;
use Illuminate\Http\Response;  // Response unused

// ✅ Fix
use Illuminate\Http\Request;  // Remove unused imports
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
```php
public function test_create_user_success()
{
    $user = User::factory()->create([
        'email' => 'john@example.com'
    ]);

    $this->assertEquals('john@example.com', $user->email);
    $this->assertNotNull($user->id);
}
```

**2. Error Cases** - Validation, edge cases
```php
public function test_create_user_invalid_email()
{
    $this->expectException(ValidationException::class);

    $this->userService->create(['email' => 'invalid-email']);
}
```

**3. Edge Cases** - Boundary conditions
```php
public function test_create_user_empty_password()
{
    $this->expectException(ValidationException::class);

    $this->userService->create([
        'email' => 'john@example.com',
        'password' => ''
    ]);
}
```

### Coverage Requirements

**Minimum Coverage:**
- Overall: >80% (or project-specific target)
- New code: 100% coverage required
- Critical paths: 100% coverage required

**Check Coverage:**
```bash
# PHP (Laravel with PHPUnit)
./vendor/bin/phpunit --coverage-html coverage/

# Or with specific path coverage
./vendor/bin/phpunit --coverage-text --coverage-filter app/

# JavaScript
npm test -- --coverage
```

### Writing Good Tests

**Test Structure (AAA Pattern):**
```php
public function test_cache_stores_reservation()
{
    // Arrange - Set up test data
    $key = 'reservation:123';
    $data = ['tour_id' => 1, 'seats' => 4];

    // Act - Execute the function
    Cache::put($key, $data, 3600);

    // Assert - Verify the result
    $cached = Cache::get($key);
    $this->assertEquals($data, $cached);
}
```

**Test Names:**
```php
// ✅ GOOD - Descriptive, explains what's tested
public function test_cache_returns_null_when_key_not_found()
{
    // ...
}

// ❌ BAD - Vague, unclear what's tested
public function test_cache()
{
    // ...
}
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
```php
/** @test */
public function it_stores_and_retrieves_from_cache()
{
    // Uses real cache instance
    Cache::put('test-key', ['data' => 'value'], 3600);

    $result = Cache::get('test-key');

    $this->assertEquals(['data' => 'value'], $result);
}
```

**2. Error Scenarios:**
```php
/** @test */
public function it_handles_database_connection_error_gracefully()
{
    // Simulate database down by using invalid connection
    config(['database.default' => 'invalid']);

    $this->expectException(QueryException::class);

    Reservation::all();
}
```

**3. Complete Workflows:**
```php
/** @test */
public function it_creates_reservation_end_to_end()
{
    // Complete flow: HTTP → Validation → Database → Response
    $tour = Tour::factory()->create();

    $response = $this->postJson('/api/reservations', [
        'tour_id' => $tour->id,
        'seats' => 4,
        'customer_name' => 'John Doe'
    ]);

    $response->assertStatus(201)
             ->assertJsonStructure(['id', 'folio', 'status']);
}
```

### Setup Requirements

**Test Environment:**
```bash
# Start services (Docker)
docker-compose up -d mysql redis

# Initialize test database
php artisan migrate:fresh --seed --env=testing

# Run integration tests
./vendor/bin/phpunit --testsuite=Feature
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
- [ ] Input validation (Form Request / Validator)?
- [ ] Authentication required (middleware)?
- [ ] Rate limiting applied (throttle)?
- [ ] No hardcoded secrets (.env used)?
- [ ] SQL injection prevented (Eloquent/bindings)?
- [ ] XSS prevention (Blade escaping)?

**Performance:**
- [ ] Eager loading where appropriate?
- [ ] No N+1 queries?
- [ ] Caching implemented?
- [ ] Resource cleanup (DB connections)?
- [ ] Heavy tasks queued?

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
```php
// ❌ Before Self Review
public function getUser(int $id): User
{
    return User::find($id);
}

// ✅ After Self Review
public function getUser(int $id): ?User
{
    try {
        $user = User::find($id);
        if (!$user) {
            return null;
        }
        return $user;
    } catch (QueryException $e) {
        Log::error("Database error: {$e->getMessage()}");
        throw new DatabaseException("Failed to fetch user");
    }
}
```

**Issue 2: Hardcoded Values**
```php
// ❌ Before Self Review
$cacheTtl = 604800;  // What is this number?

// ✅ After Self Review
$cacheTtl = 7 * 24 * 60 * 60;  // 7 days in seconds
// Or better: use config
$cacheTtl = config('cache.ttl_days') * 86400;
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

**Task:** Implement reservation caching with Redis

### Timeline

```
00:00 - Step 1: Context7 Review (5 min)
  → Query "Laravel caching patterns"
  → Learn: Use Cache facade, Redis driver, TTL

00:05 - Step 2: Plan & Implement (20 min)
  → Design: CacheService with get/set/forget
  → Generate: Gemini creates boilerplate (180 lines)
  → Refine: Claude adds error handling (67 lines)

00:25 - Step 3: Code Quality (3 min)
  → pint: ✓ formatted
  → phpstan: ✓ 0 errors
  → php -l: ✓ syntax valid

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
  → Patterns: ✓ Eloquent ORM, dependency injection
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
