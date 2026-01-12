# Claude + Gemini Hybrid Workflow

---
**Purpose:** Token-efficient development maintaining quality standards
**Priority:** HIGH (MANDATORY for all implementation tasks)
**Version:** 1.0.0
---

## 🔒 INVIOLABLE PRINCIPLE: Quality Over Speed

**TIME TO COMPLETE IS IRRELEVANT**

This framework prioritizes:
1. **Token Savings** - Preserve Claude's tokens for complex problems
2. **Code Quality** - Maintain high standards through review
3. **Process Adherence** - Follow the workflow consistently
4. **User Satisfaction** - Deliver correct solutions, not fast solutions

**Explicitly NOT Prioritized:**
- ❌ Implementation speed
- ❌ Time to complete tasks
- ❌ Number of tasks per hour
- ❌ Response latency

**Why This Matters:**
- Fast, wrong code wastes MORE time in debugging
- Rushing bypasses quality gates → Technical debt
- Token savings compound over project lifetime
- Consistent quality builds trust and reliability

**Enforcement:**
- Never justify "faster to write directly" (violates workflow)
- Never skip Gemini due to "taking too long" (be patient)
- Never rush through review steps to save time
- Always follow the complete process, regardless of duration

---

## Core Principle

**Use Gemini for generation, Claude for intelligence.**

Gemini excels at bulk code generation. Claude provides superior reasoning, architecture, and quality assurance.

**Target:** Offload 60-70% of code volume to Gemini while Claude handles critical 30-40%.

---

## Agent Roles

### Claude Code (Master Agent)
**Responsibilities:**
- Architecture and design decisions
- Complex problem-solving and algorithms
- Code review and quality assurance
- Debugging complex issues
- Security analysis
- Performance optimization
- Integration of systems
- Critical business logic
- User communication and approval

### Gemini CLI (Sub-Agent)
**Responsibilities:**
- Boilerplate code generation
- Pattern replication
- Test generation
- Data model creation
- Repository and service classes
- Configuration files
- Documentation generation
- Mechanical refactoring

**See:** `templates/gemini-subagent-role.md` for complete Gemini responsibilities

---

## 🔒 INVIOLABLE RULE: Token Savings Over Speed

Token savings are MORE valuable than implementation speed.

**Rules:**
- ✅ **ALWAYS use Gemini for boilerplate** - Even if multiple attempts needed
- ✅ **Be patient with AI CLI** - Work through errors, don't bypass
- ✅ **Never skip to direct writing** - Only as absolute last resort
- ❌ **Never justify "faster to write directly"** - Violates workflow
- ❌ **Never skip Gemini due to issues** - Debug first, don't bypass

**Why:**
- Token savings compound over time (60-70% reduction target)
- Direct writing burns Claude tokens on routine code
- Hybrid workflow maintains quality while preserving tokens
- Speed comes from workflow mastery, not shortcuts

**When Tempted to Skip Gemini:**
1. STOP - Recognize the impulse
2. REMEMBER - Token savings are the goal
3. TRY - Adjust prompt, use Context7, try different approach
4. ESCALATE - If truly stuck, document why before bypassing

---

## Workflow Strategy

### When to Use Gemini

**Code Generation Tasks:**
- Scaffolding and boilerplate
- CRUD operations
- Similar components
- Data models and schemas
- Test cases following patterns
- Repository classes
- Service classes with clear specs
- Configuration files
- Documentation generation

**Command Execution (YOLO mode):**
- Running tests (`pytest`)
- Quality checks (`black`, `ruff`, `mypy`)
- Git operations
- System commands

### When to Use Claude

**Strategic Work:**
- Architecture and design decisions
- Technology selection
- Complex algorithms
- Code review and quality assurance
- Debugging complex issues
- Security analysis
- Performance optimization
- Integration of complex systems
- Critical business logic
- Ambiguous requirements

---

## 5-Step Protocol

**When Claude Detects Boilerplate Needed:**

### Step 1: 🛑 STOP
- Don't write boilerplate code directly
- Recognize this is a Gemini task
- Resist urge to "save time" by writing directly

### Step 2: 🔍 Context7 Review (MANDATORY)
```bash
# Research best practices BEFORE generating
gemini -m gemini-2.5-pro --allowed-mcp-server-names context7 "Search Context7 for [library] [pattern] best practices. REPORT key patterns ONLY."
```

### Step 3: 🤖 Gemini Generation
```bash
# Generate code using Context7 patterns
gemini -m gemini-2.5-pro "@pattern.py @context/06-coding-standards.md Generate [component] following Context7 patterns. Output code as text ONLY. DO NOT create files." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

### Step 4: 🔍 Claude Review
- Analyze Gemini's output for correctness
- Verify Context7 patterns applied
- Check for security issues
- Ensure error handling complete
- Validate against project standards
- Fix any issues identified

### Step 5: ✍️ Claude Writes
- Use Write/Edit tools to create files
- Apply reviewed code
- Add any refinements needed

### Step 6: ✅ Verify (Optional - YOLO mode)
```bash
# Run tests via Gemini
gemini -m gemini-2.5-pro --yolo "Run pytest tests/test_new_code.py -v"
```

---

## Session Workflow

### Phase 1: Session Initialization (2-3 min)

**Initialize Gemini's ephemeral memory:**
```bash
gemini -m gemini-2.5-pro "Remember for this session:

PROJECT: [Project Name]
TECH STACK:
- [Language]: [version]
- [Framework]: [version]
- [Database]: [version]

PATTERNS:
- [Critical pattern 1]
- [Critical pattern 2]

STANDARDS:
- Format: [tool]
- Lint: [tool]
- Type check: [tool]

CURRENT TASK: [Story XX / Bug YY]

Confirm you have saved this context."
```

**Gemini Response:** "I have saved this context for our session. Ready to generate code."

### Phase 2: Development (Variable Duration)

**Remember: Time duration doesn't matter. Quality matters.**

**Typical Flow:**
1. Claude designs architecture/interface
2. Claude runs Context7 review
3. Claude requests code from Gemini
4. Gemini generates using remembered context
5. Claude reviews output thoroughly (take time!)
6. Claude refines if needed (don't rush!)
7. Claude writes files
8. Repeat for next component

**No Time Pressure:**
- Take breaks between generations
- Review thoroughly, not quickly
- Debug Gemini issues patiently
- Iterate until quality is right

### Phase 3: Session Cleanup (1 min) - MANDATORY

**Clear Gemini's memory:**
```bash
gemini -m gemini-2.5-pro "Session ending. Forget ALL memories. Clear all saved context. Confirm cleanup complete."

# Verify cleanup
gemini -m gemini-2.5-pro "What do you remember?"
# Expected: "I have no saved memories."
```

---

## Communication Examples

### Example 1: Repository Generation

**Claude → Gemini:**
```bash
gemini -m gemini-2.5-pro "@app/repositories/token_repository.py @context/06-coding-standards.md Generate RecipeCacheRepository with methods: get_cached_recipe(video_url), cache_recipe(video_url, recipe_data, ttl_days=7), invalidate_cache(video_url), get_cache_stats(). Follow Motor async patterns from token_repository.py. Output complete code as text ONLY."
```

**Gemini → Claude:**
```python
"""Recipe cache repository for MongoDB operations"""
from typing import Optional
from datetime import datetime, timedelta
from motor.motor_asyncio import AsyncIOMotorDatabase

class RecipeCacheRepository:
    """Handle recipe caching with automatic TTL expiration"""

    def __init__(self, db: AsyncIOMotorDatabase):
        self.collection = db.recipe_cache

    async def get_cached_recipe(self, video_url: str) -> Optional[dict]:
        """Retrieve cached recipe by video URL"""
        return await self.collection.find_one({"video_url": video_url})

    # ... (complete implementation)
```

**Claude Reviews:**
- ✅ Follows Motor patterns
- ✅ Type hints complete
- ✅ Docstrings present
- ⚠️  Missing TTL index setup (Claude adds separately)

**Claude Writes:** Creates file with reviewed code

### Example 2: Test Generation

**Claude → Gemini:**
```bash
gemini -m gemini-2.5-pro --allowed-mcp-server-names context7 "@app/services/recipe_service.py Generate pytest tests for RecipeService following Context7 best practices for async FastAPI testing. Include fixtures, mocks, success/error cases. Output complete test code as text ONLY."
```

**Gemini → Claude:** [Complete test file with pytest fixtures, async tests, mocks]

**Claude Reviews:** Checks test coverage, edge cases, mock setup

**Claude Writes:** Creates test file

---

## Context7 MCP Integration

**🔒 MANDATORY: Always use Context7 before generating library-specific code**

**Verification:**
```bash
gemini mcp list
# Should show: ✓ context7: https://mcp.context7.com/mcp (http) - Connected
```

**Usage Pattern:**
```bash
# Step 1: Research
gemini -m gemini-2.5-pro --allowed-mcp-server-names context7 "Search Context7 for [library] [topic] best practices. REPORT key patterns."

# Step 2: Generate using those patterns
gemini -m gemini-2.5-pro "@pattern.py Generate code following Context7 patterns. Output as text."
```

**Benefits:**
- ✅ Up-to-date library patterns
- ✅ Higher quality output
- ✅ Fewer errors to fix
- ✅ Official documentation applied

---

## Web Search Integration

**🌐 NEW: Web search for research and technical documentation**

**Syntax:**
```bash
gemini -m gemini-2.5-pro 'google_web_search(query="your search query")' 2>&1 | grep -v "^\[ERROR\]" | grep -v "^Loaded"
```

**How It Works:**
- Returns summarized results with citations (not raw search results)
- Powered by Gemini API's web search capability
- Takes 5-30 seconds depending on query complexity
- Can combine with follow-up instructions

**Use Cases:**
- ✅ Research unfamiliar libraries before implementation
- ✅ Find official documentation URLs and specs
- ✅ Look up API methods and interfaces
- ✅ Discover architectural patterns and best practices
- ✅ Check latest versions and breaking changes
- ❌ Don't use for real-time code generation (research first, code later)
- ❌ Don't use for simple questions Gemini already knows

**Example - Complete Research Workflow:**
```bash
# Step 1: Web search for official documentation
gemini -m gemini-2.5-pro 'google_web_search(query="Minio TypeScript SDK official documentation methods")' 2>&1 | grep -v "^\[ERROR\]" | grep -v "^Loaded"
# Output: Links to Minio docs, key methods summary

# Step 2: Use Context7 for implementation patterns
gemini -m gemini-2.5-pro --allowed-mcp-server-names context7 "Search Context7 for Minio SDK best practices. REPORT key patterns."
# Output: Code examples and patterns

# Step 3: Generate code with both insights
gemini -m gemini-2.5-pro "@pattern.py Generate MinioClient with putObject, getObject methods following discovered patterns. Output as text." 2>&1 | grep -v "^\[" | grep -v "^Loaded"
```

**Example - Follow-up Instructions:**
```bash
# Search + immediate processing
gemini -m gemini-2.5-flash 'google_web_search(query="Claude Agent SDK Python installation") Provide the pip install command and link to docs.' 2>&1 | grep -v "^\[ERROR\]" | grep -v "^Loaded"
# Output: pip install claude-agent-sdk + URLs
```

**When to Use:**
- **Research Phase:** Use web search to discover libraries, APIs, patterns
- **Implementation Phase:** Use Context7 for code-specific patterns
- **Generation Phase:** Use Gemini with @ file context for actual code

**Performance:**
- gemini-2.5-flash: 5-10 seconds (faster, good for simple queries)
- gemini-2.5-pro: 10-30 seconds (deeper, better for complex research)

---

## Token Savings Target

**Goal:** 60-70% of code volume generated by Gemini

**Measurement:**
```bash
# Calculate Gemini-generated lines
GEMINI_LINES=$(find app/ -name "*.py" -exec wc -l {} + | grep -i "gemini" | awk '{sum+=$1} END {print sum}')
TOTAL_LINES=$(find app/ -name "*.py" -exec wc -l {} + | tail -1 | awk '{print $1}')
PERCENTAGE=$((GEMINI_LINES * 100 / TOTAL_LINES))
echo "Gemini generated: $PERCENTAGE% of codebase"
```

**Target:** 60-70% (good), 70-80% (excellent), >80% (exceptional)

---

## Quality Checkpoints

**Never Skip:**
- ✅ Context7 review before generation
- ✅ Claude review of ALL Gemini output
- ✅ Security analysis of generated code
- ✅ Pattern consistency verification
- ✅ Error handling validation

**When to Return to Claude:**
- Code needs significant revision (>30% changes)
- Security concerns identified
- Performance issues detected
- Ambiguity in requirements
- Pattern conflicts found

---

## Time Management Philosophy

**Core Belief:** Quality compounds, speed doesn't.

**Good Time Allocation:**
- Context7 research: 2-5 min (invest upfront)
- Gemini generation: 1-3 min (be patient)
- Claude review: 3-10 min (thorough, not rushed)
- Refinement: Variable (until correct)
- Testing: 2-5 min (comprehensive)

**Bad Time Allocation:**
- Rushing Claude review to "save time"
- Skipping Context7 to "go faster"
- Writing directly because "Gemini is slow"
- Accepting poor quality to "finish quickly"

**Remember:** A 30-minute quality implementation is better than a 5-minute rushed implementation that needs 2 hours of debugging.

---

## Success Metrics

**Primary Metrics:**
- Token usage reduction: 60-70% target
- Code quality maintained: >90% acceptance
- Test pass rate: 100% required
- User satisfaction: High confidence in solutions

**Secondary Metrics (informational only):**
- Average generation time
- Gemini success rate
- Review cycle count
- Context7 usage frequency

**NOT Measured:**
- Time to complete tasks ❌
- Speed of implementation ❌
- Tasks per hour ❌

---

## Troubleshooting

### Problem: Gemini Generation Taking Long

**Mindset:** This is fine. Be patient.

**Actions:**
- Check Context7 search isn't hanging
- Verify prompt is clear
- Ensure file context isn't too large
- Try breaking into smaller chunks

**DON'T:** Skip to direct writing

### Problem: Multiple Gemini Attempts Needed

**Mindset:** This is normal. Iterate.

**Actions:**
- Refine prompt clarity
- Add more context examples
- Check for pattern conflicts
- Use Context7 for better patterns

**DON'T:** Give up and write directly

### Problem: Claude Review Finding Many Issues

**Mindset:** Good! Review is working.

**Actions:**
- Fix issues in Gemini output
- Update prompts for future
- Document common issues
- Improve context examples

**DON'T:** Lower review standards

---

## Best Practices

### DO ✅
1. Always initialize Gemini at session start
2. Always use Context7 before library-specific code
3. Always review Gemini output thoroughly
4. Always clean up Gemini memory at session end
5. Be patient with generation process
6. Iterate prompts until quality is right
7. Document patterns that work well
8. Track token savings metrics

### DON'T ❌
1. Never write boilerplate directly
2. Never skip Context7 review
3. Never rush through Claude review
4. Never accept poor quality for speed
5. Never justify "faster to do it myself"
6. Never skip session cleanup
7. Never measure success by speed
8. Never compromise quality for time

---

## Integration with 8-Step Verification

**Step 1: Context7 Review** → Use Gemini CLI with Context7 MCP
**Step 2: Code Generation** → Gemini generates, Claude reviews
**Step 3: Code Quality** → Run via Gemini YOLO mode or Claude
**Step 4-5: Testing** → Gemini can generate tests, Claude reviews
**Step 6-8:** → Claude handles (approval, documentation)

**Time for 8 steps:** Variable, doesn't matter. Completing all steps correctly matters.

---

## Philosophy Summary

**Old Mindset (WRONG):**
- "Let me write this quickly instead of using Gemini"
- "Gemini is taking too long, I'll do it myself"
- "We need to finish fast"
- "Time to complete is important"

**New Mindset (CORRECT):**
- "Let me get this right using the proper workflow"
- "I'll be patient with Gemini and iterate until quality is right"
- "We need to finish correctly"
- "Quality and token savings are important"

**Remember:** This framework optimizes for:
1. Token efficiency (save Claude for complex work)
2. Code quality (maintain high standards)
3. Process consistency (repeatable results)
4. Long-term value (compounds over time)

**NOT optimized for:**
- ❌ Fast completion
- ❌ Minimal time
- ❌ Quick turnaround

---

**Version:** 1.0.0
**Last Updated:** 2025-01-24
**Status:** Mandatory for all implementation work
