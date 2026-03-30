# Design System Philosophy: The Precision Architect

### 1. Overview & Creative North Star
The Creative North Star for this design system is **"The Precision Architect."** Inspired by the International Typographic Style (Swiss Design), this system rejects the generic "bubbly" web of the last decade in favor of mathematical rigor, objective clarity, and high-end editorial authority. 

To elevate "DesarrolloTuWeb" from a standard agency to a boutique powerhouse, we move beyond simple minimalism. We embrace **intentional asymmetry** and **structural tension**. By utilizing a strict 0px radius (hard edges) and a sophisticated tonal hierarchy, we create a digital environment that feels engineered, not just "designed." The layout should feel like a premium architectural blueprint: spacious, authoritative, and impeccably organized.

### 2. Colors: Tonal Depth & The "No-Line" Rule
The palette is anchored by a high-contrast relationship between a pristine background and an "Electric Blue" that signifies technological pulse.

*   **Primary (`#0059bb`):** Our Electric Blue. Use this sparingly as a "signal" color—for active states, primary CTAs, and critical brand moments.
*   **Surface Hierarchy:** We strictly adhere to the **"No-Line" Rule**. Designers are prohibited from using 1px solid borders to separate sections. Instead, boundaries are defined by the background shift:
    *   **Level 0:** Base page uses `surface`.
    *   **Level 1:** Secondary sections or sidebars use `surface-container-low`.
    *   **Level 2:** Floating elements or elevated cards use `surface-container-lowest`.
*   **Glass & Gradient:** To add "soul" to the Swiss rigidity, use `surface_tint` at 5% opacity with a `backdrop-blur(20px)` for navigation bars. For hero CTAs, a subtle linear gradient from `primary` to `primary_container` is permitted to provide a sense of depth and tactile quality.

### 3. Typography: The Editorial Voice
We utilize a pairing of **Manrope** for impact and **Inter** for utility. This combination bridges the gap between geometric modernism and technical precision.

*   **Display & Headlines (Manrope):** Use `display-lg` (3.5rem) for hero statements. To break the "template" look, use "Generous Weight Variations"—pair a `display-lg` in Bold with a `title-md` in Light immediately beneath it. This creates high-contrast rhythmic tension.
*   **Body & Labels (Inter):** All functional text uses Inter. `body-lg` (1rem) is the standard for readability. For a "boutique" feel, increase the letter-spacing of `label-sm` to 0.05rem and use uppercase for all-caps "Overlines" above headlines.
*   **Hierarchy as Identity:** The scale is the brand. A massive, left-aligned `display-md` title with significant `spacing-20` of whitespace below it communicates more "luxury" than any graphic ever could.

### 4. Elevation & Depth: Tonal Layering
Since the roundedness scale is fixed at **0px**, we cannot rely on "softness" to convey depth. We use **Tonal Layering**.

*   **The Layering Principle:** Place a `surface-container-lowest` card on top of a `surface-container-high` section. The hard edges combined with the slight tonal shift create a "paper-on-table" effect that feels premium and tactile.
*   **Ambient Shadows:** Traditional drop shadows are forbidden. If a floating element (like a modal) requires separation, use an **Ambient Shadow**: `0px 24px 48px rgba(25, 28, 30, 0.06)`. The shadow must be almost invisible, mimicking the soft occlusion of natural light in a studio.
*   **The Ghost Border:** For interactive elements like input fields, use a "Ghost Border": the `outline-variant` token at 15% opacity. It provides a guide without cluttering the visual field.

### 5. Components: Structural Integrity

*   **Buttons:**
    *   **Primary:** Solid `primary` background, `on_primary` text. Hard 0px corners. No shadow. On hover, transition to `primary_container`.
    *   **Tertiary:** No background, `primary` text. Underline on hover using a 2px stroke of `primary_fixed`.
*   **Input Fields:**
    *   Use `surface-container-low` as the fill. The bottom border is a 1px stroke of `outline`. On focus, the bottom border thickens to 2px of `primary`.
*   **Cards:**
    *   Never use a border. Use `surface-container-lowest`. Use `spacing-8` for internal padding to ensure "breathing room."
*   **Founder Section (The Direct Touch):**
    *   For Nicolás and Martín’s direct contact, use a "Split-Screen" component. One side is a high-contrast grayscale portrait; the other side is a `surface-container-highest` block containing their direct contact details. This creates a "personalized yet professional" look.
*   **Lists:**
    *   Forbid dividers. Use `spacing-4` between list items. Use a small `primary` square (4px) as a bullet point to reinforce the "tech-forward" geometric aesthetic.

### 6. Do's and Don'ts

*   **DO:** Use asymmetrical layouts. If a headline is left-aligned, place the body text in a narrower column shifted to the right.
*   **DO:** Lean into whitespace. If you think there is enough space, add `spacing-6` more. 
*   **DON'T:** Use rounded corners. Not even 2px. The 0px rule is absolute to maintain the "Architect" identity.
*   **DON'T:** Use icons with different stroke weights. Use "Thin Line Icons" (1px or 1.5px stroke) exclusively to match the `outline` token's weight.
*   **DO:** Ensure accessibility. The high-contrast `on_surface` (#191C1E) against `background` (#F7F9FB) must always maintain a ratio of at least 7:1 for headers.

By following this system, the "DesarrolloTuWeb" interface will not just be another website; it will be a digital statement of intent—precise, personalized, and unapologetically modern.