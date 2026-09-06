#!/usr/bin/env bash
#
# Builds the release zip for upload to the Freemius developer dashboard.
#
# This zip is the PREMIUM codebase. Freemius strips the __premium_only files
# from it and generates the free build that ships to WordPress.org, so never
# upload a hand-built free zip to the WordPress.org SVN.
#
# Usage: npm run release
#
set -euo pipefail

cd "$(dirname "$0")/.."

SLUG="$(basename "$PWD")"
VERSION="$(node -p "require('./package.json').version")"
OUT_DIR="release"
ZIP_NAME="$SLUG-$VERSION.zip"

echo "==> $SLUG $VERSION"

# ---------------------------------------------------------------------------
# 1. Version consistency. The version lives in five places and it is easy to
#    miss one during a bump, which ships a plugin whose header disagrees with
#    its readme.
# ---------------------------------------------------------------------------
echo "==> Checking version consistency"
declare -a MISMATCH=()
check_version() {
	local file="$1" pattern="$2"
	local found
	found="$(grep -oE "$pattern" "$file" | grep -oE '[0-9]+\.[0-9]+\.[0-9]+' | head -1 || true)"
	if [ "$found" != "$VERSION" ]; then
		MISMATCH+=("$file has '${found:-none}', expected '$VERSION'")
	fi
}
check_version "wp-coupons-deals.php" '\* Version: *[0-9.]+'
check_version "readme.txt"           'Stable tag: *[0-9.]+'
check_version "includes/main.php"    "PLUGIN_VERSION *= *'[0-9.]+'"
check_version "package-lock.json"    '"version": *"[0-9.]+"'

if [ ${#MISMATCH[@]} -gt 0 ]; then
	printf '    %s\n' "${MISMATCH[@]}" >&2
	echo "    Version mismatch, aborting." >&2
	exit 1
fi
echo "    all five locations agree on $VERSION"

# ---------------------------------------------------------------------------
# 2. Production build. `npm start` leaves an unminified dev build in build/,
#    which would otherwise ship as-is and roughly triple the bundle size.
# ---------------------------------------------------------------------------
echo "==> Building production assets"
npm run build --silent

# ---------------------------------------------------------------------------
# 3. Zip. Only what the plugin needs at runtime. Everything else is tooling.
# ---------------------------------------------------------------------------
echo "==> Creating $OUT_DIR/$ZIP_NAME"
mkdir -p "$OUT_DIR"
rm -f "$OUT_DIR/$ZIP_NAME"

cd ..
zip -rq "$SLUG/$OUT_DIR/$ZIP_NAME" "$SLUG" \
	-x "$SLUG/node_modules/*" \
	   "$SLUG/.git/*" \
	   "$SLUG/src/*" \
	   "$SLUG/tests/*" \
	   "$SLUG/bin/*" \
	   "$SLUG/$OUT_DIR/*" \
	   "*/.DS_Store" \
	   "$SLUG/package.json" \
	   "$SLUG/package-lock.json" \
	   "$SLUG/composer.lock" \
	   "$SLUG/webpack*.js" \
	   "$SLUG/webpackPaths.js" \
	   "$SLUG/gulpfile.js" \
	   "$SLUG/postcss.config.js" \
	   "$SLUG/.eslintrc.json" \
	   "$SLUG/phpunit.xml" \
	   "$SLUG/.gitignore" \
	   "$SLUG/CLAUDE.md" \
	   "$SLUG/AGENTS.md" \
	   "$SLUG/README.md"
cd "$SLUG"

# ---------------------------------------------------------------------------
# 4. Sanity check the result rather than trusting the exclude list.
# ---------------------------------------------------------------------------
echo "==> Verifying"
LIST="$(unzip -l "$OUT_DIR/$ZIP_NAME")"
FAILED=0
for junk in "$SLUG/node_modules/" "$SLUG/.git/" "$SLUG/src/" "$SLUG/tests/" ".DS_Store" "$SLUG/package.json" "$SLUG/gulpfile.js"; do
	if echo "$LIST" | grep -q -- "$junk"; then
		echo "    LEAKED: $junk" >&2
		FAILED=1
	fi
done
if ! echo "$LIST" | grep -q "$SLUG/wp-coupons-deals.php"; then
	echo "    MISSING: main plugin file" >&2
	FAILED=1
fi
[ "$FAILED" -eq 0 ] || { echo "    Verification failed." >&2; exit 1; }

PREMIUM_COUNT="$(echo "$LIST" | grep -c "__premium_only" || true)"
echo "    no build tooling leaked, main plugin file present"
echo "    $PREMIUM_COUNT __premium_only files included (Freemius strips these for the free build)"
echo
echo "Done: $OUT_DIR/$ZIP_NAME ($(du -h "$OUT_DIR/$ZIP_NAME" | cut -f1 | tr -d ' '))"
echo "Next: upload it to the Freemius dashboard, then release the free build to WordPress.org."
